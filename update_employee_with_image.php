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
        $appointmentDate = $_POST['employees_appointmentDate'];
        $leaveVacation = $_POST['Leave_Vacation'];
        $leaveSick = $_POST['Leave_Sick'];
        $leaveForce = $_POST['Leave_Force'];
        $leaveSpecial = $_POST['Leave_Special'];
        // Retrieve the employee image file
        $image = $_FILES['employees_image'];

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

        // prepare and execute the query to update the department
        $query = "UPDATE employees SET  employees_image = ?, 
                                        employees_FirstName = ?, 
                                        employees_MiddleName = ?, 
                                        employees_LastName = ?,
                                        employees_sex = ?,
                                        employees_birthdate = ?,
                                        employees_Department = ?,
                                        employees_appointmentDate = ?,
                                        Leave_Vacation = ?,
                                        Leave_Sick = ?,
                                        Leave_Force = ?,
                                        Leave_Special = ?
                                        WHERE uID = ? ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "ssssssssssssi",
            $blobbed,
            $firstName,
            $middleName,
            $lastName,
            $sex ,
            $birthdate,
            $departmentId,
            $appointmentDate,
            $leaveVacation,
            $leaveSick ,
            $leaveForce,
            $leaveSpecial,
            $uid
        );

        // execute the query and check for errors
        if ($stmt->execute()) {
            // check if any rows were affected
            if ($stmt->affected_rows > 0) {
                // Department updated successfully
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

//// Remove the uploaded temporary file
//unlink($targetFileName);

// close the database connection
$conn->close();

echo json_encode(['response' => $response]);
