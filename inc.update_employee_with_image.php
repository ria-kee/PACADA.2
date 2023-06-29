<?php

include('includes/dbh.inc.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // check if the required data is provided
    $missingParameters = [];
    $requiredParameters = [
        'uid',
        'employees_FirstName',
        'employees_MiddleName',
        'employees_LastName',
        'employees_sex',
        'employees_birthdate',
        'employees_Department',
        'employees_type',
        'employees_appointmentDate',
        'Leave_Vacation',
        'Leave_Sick',
        'Leave_Force',
        'Leave_Special'
    ];

    foreach ($requiredParameters as $parameter) {
        if (!isset($_POST[$parameter])) {
            $missingParameters[] = $parameter;
        }
    }

    if (empty($missingParameters)) {
        // Retrieve the employee data from the regular form fields
        $uid = $_POST['uid'];
        $firstName = $_POST['employees_FirstName'];
        $middleName = $_POST['employees_MiddleName'];
        $lastName = $_POST['employees_LastName'];
        $sex = $_POST['employees_sex'];
        $birthdate = $_POST['employees_birthdate'];
        $departmentId = $_POST['employees_Department'];
        $type = $_POST['employees_type'];
        $appointmentDate = $_POST['employees_appointmentDate'];
        $leaveVacation = $_POST['Leave_Vacation'];
        $leaveSick = $_POST['Leave_Sick'];
        $leaveForce = $_POST['Leave_Force'];
        $leaveSpecial = $_POST['Leave_Special'];
        // Retrieve the employee image file
        $image = $_FILES['employees_image'];
        $employees_remarks = $_POST['employees_remarks'];

        // Retrieve the original file name
        $blobName = $_FILES['employees_image']['name'];

        // Move the uploaded image file to a permanent location
        $targetDirectory = 'assets/profiles/';
        $imageExtension = pathinfo($blobName, PATHINFO_EXTENSION);
        $imageName = $uid. '.' . $imageExtension;
        $targetFileName = $targetDirectory . $imageName;
        move_uploaded_file($_FILES['employees_image']['tmp_name'], $targetFileName);
        $imageContent = file_get_contents($targetFileName);
        // Create a Blob object
        $blob = new stdClass();
        $blob->type = mime_content_type($targetFileName);
        $blob->data = base64_encode($imageContent);
        $blobbed = $blob->data;

        // Get the existing employee data before updating
        $existingDataQuery = "SELECT employees_FirstName, employees_MiddleName, employees_LastName, employees_sex, employees_birthdate, employees_Department,employees_type, employees_appointmentDate, Leave_Vacation, Leave_Sick, Leave_Force, Leave_Special, employees_remarks, employees_image, employees_uid FROM employees WHERE uID = ?";
        $stmt_existingData = $conn->prepare($existingDataQuery);
        $stmt_existingData->bind_param("i", $uid);
        $stmt_existingData->execute();
        $stmt_existingData->store_result();
        $stmt_existingData->bind_result(
            $existingFirstName,
            $existingMiddleName,
            $existingLastName,
            $existingSex,
            $existingBirthdate,
            $existingDepartmentId,
            $existingType,
            $existingAppointmentDate,
            $existingLeaveVacation,
            $existingLeaveSick,
            $existingLeaveForce,
            $existingLeaveSpecial,
            $existingRemarks,
            $existingImage,
            $existingUID
        );
        $stmt_existingData->fetch();
        $stmt_existingData->free_result();
        $stmt_existingData->close();

        // Prepare an array to store the changes
        $changes = [];

        // Check each field for changes and add them to the changes array
        if ($existingFirstName !== $firstName) {
            $changes[] = "First Name: {$existingFirstName} -> {$firstName}";
        }
        if ($existingMiddleName !== $middleName) {
            $changes[] = "Middle Name: {$existingMiddleName} -> {$middleName}";
        }
        if ($existingLastName !== $lastName) {
            $changes[] = "Last Name: {$existingLastName} -> {$lastName}";
        }
        if ($existingSex !== $sex) {
            $changes[] = "Sex: {$existingSex} -> {$sex}";
        }
        if ($existingBirthdate !== $birthdate) {
            $changes[] = "Birthdate: {$existingBirthdate} -> {$birthdate}";
        }
        if ($existingDepartmentId != $departmentId) {
            $changes[] = "Department: {$existingDepartmentId} -> {$departmentId}";
        }
        if ($existingType != $type) {
            $changes[] = "Type: {$existingType} -> {$type}";
        }
        if ($existingAppointmentDate !== $appointmentDate) {
            $changes[] = "Appointment Date: {$existingAppointmentDate} -> {$appointmentDate}";
        }
        if ($existingLeaveVacation !== $leaveVacation) {
            $changes[] = "Vacation Leave: {$existingLeaveVacation} -> {$leaveVacation}";
        }
        if ($existingLeaveSick !== $leaveSick) {
            $changes[] = "Sick Leave: {$existingLeaveSick} -> {$leaveSick}";
        }
        if ($existingLeaveForce !== $leaveForce) {
            $changes[] = "Force Leave: {$existingLeaveForce} -> {$leaveForce}";
        }
        if ($existingLeaveSpecial !== $leaveSpecial) {
            $changes[] = "Special Leave: {$existingLeaveSpecial} -> {$leaveSpecial}";
        }
        if ($existingRemarks !== $employees_remarks) {
            $changes[] = "employees remarks: {$existingRemarks} -> {$employees_remarks}";
        }
        if ($existingImage !== $blobbed) {
            $changes[] = "employees image: Image updated";
        }

        // prepare and execute the query to update the department
        $query = "UPDATE employees SET  employees_image = ?, 
                                        employees_FirstName = ?, 
                                        employees_MiddleName = ?, 
                                        employees_LastName = ?,
                                        employees_sex = ?,
                                        employees_birthdate = ?,
                                        employees_Department = ?,
                                        employees_type = ?,
                                        employees_appointmentDate = ?,
                                        Leave_Vacation = ?,
                                        Leave_Sick = ?,
                                        Leave_Force = ?,
                                        Leave_Special = ?,
                                        employees_remarks = ?
                                        WHERE uID = ? ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "ssssssssssssssi",
            $blobbed,
            $firstName,
            $middleName,
            $lastName,
            $sex ,
            $birthdate,
            $departmentId,
            $type,
            $appointmentDate,
            $leaveVacation,
            $leaveSick ,
            $leaveForce,
            $leaveSpecial,
            $employees_remarks,
            $uid
        );

        // execute the query and check for errors
        if ($stmt->execute()) {
            // check if any rows were affected
            if ($stmt->affected_rows > 0) {
                // Log the changes
                if (!empty($changes)) {
                    session_start();
                    $action = 'edited';
                    $toWhom = $existingUID;

                    // Loop through each change and log it
                    foreach ($changes as $change) {
                        $query_log = "INSERT INTO logs (admin_uID, admin_Name, admin_Action, action_what, action_toWhom) VALUES (?, ?, ?, ?, ?)";
                        $stmt_log = $conn->prepare($query_log);
                        $stmt_log->bind_param("issss", $_SESSION['admin_uID'], $_SESSION['admin_FirstName'], $action, $change, $toWhom);

                        if ($stmt_log->execute()) {
                            // Log entry added successfully
                        } else {
                            // Failed to add log entry
                            $response = ['success' => false, 'message' => 'Failed to add log entry.'];
                            break;
                        }

                        $stmt_log->close();
                    }
                }

                $response = ['success' => true];
            } else {
                // Department not found or no changes made
                $response = ['success' => false, 'message' => 'Employee not found or no changes made.'];
            }
        } else {
            // Failed to execute the query
            $response = ['success' => false, 'message' => $conn->error];
        }

        // close the statement
        $stmt->close();
    } else {
        if (count($missingParameters) === count($requiredParameters)) {
            $response = ['success' => false, 'message' => 'All required parameters are missing.'];
        } else {
            $response = ['success' => false, 'message' => 'Missing required parameters.', 'missingParameters' => $missingParameters];
        }
    }
} else {
    $response = ['success' => false, 'message' => 'Invalid request method.'];
}

// Remove the uploaded temporary file
unlink($targetFileName);

// close the database connection
$conn->close();

echo json_encode(['response' => $response]);
