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
        $employees_remarks = $_POST['employees_remarks'];

        // Retrieve the existing employee data from the database
        $query = "SELECT employees_uID,
                         employees_FirstName,
                         employees_MiddleName,
                         employees_LastName,
                         employees_sex,
                         employees_birthdate,
                         employees_Department,
                         employees_appointmentDate,
                         Leave_Vacation,
                         Leave_Sick,
                         Leave_Force,
                         Leave_Special,
                         employees_remarks
                  FROM employees
                  WHERE uID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $uid);
        $stmt->execute();
        $stmt->bind_result(
            $existingUID,
            $existingFirstName,
            $existingMiddleName,
            $existingLastName,
            $existingSex,
            $existingBirthdate,
            $existingDepartmentId,
            $existingAppointmentDate,
            $existingLeaveVacation,
            $existingLeaveSick,
            $existingLeaveForce,
            $existingLeaveSpecial,
            $existingRemarks);
        $stmt->fetch();
        $stmt->close();

        // Compare the existing data with the new data to identify changes
        $changes = [];

        if ($firstName !== $existingFirstName) {
            $changes['employees_FirstName'] = [
                'old' => $existingFirstName,
                'new' => $firstName
            ];
        }
        if ($middleName !== $existingMiddleName) {
            $changes['employees_MiddleName'] = [
                'old' => $existingMiddleName,
                'new' => $middleName
            ];
        }
        if ($lastName !== $existingLastName) {
            $changes['employees_LastName'] = [
                'old' => $existingLastName,
                'new' => $lastName
            ];
        }
        if ($sex !== $existingSex) {
            $changes['employees_sex'] = [
                'old' => $existingSex,
                'new' => $sex
            ];
        }
        if ($birthdate !== $existingBirthdate) {
            $changes['employees_birthdate'] = [
                'old' => $existingBirthdate,
                'new' => $birthdate
            ];
        }
        if ($departmentId != $existingDepartmentId) {
            $changes['employees_Department'] = [
                'old' => $existingDepartmentId,
                'new' => $departmentId
            ];
        }
        if ($appointmentDate !== $existingAppointmentDate) {
            $changes['employees_appointmentDate'] = [
                'old' => $existingAppointmentDate,
                'new' => $appointmentDate
            ];
        }
        if ($leaveVacation !== $existingLeaveVacation) {
            $changes['Leave_Vacation'] = [
                'old' => $existingLeaveVacation,
                'new' => $leaveVacation
            ];
        }
        if ($leaveSick !== $existingLeaveSick) {
            $changes['Leave_Sick'] = [
                'old' => $existingLeaveSick,
                'new' => $leaveSick
            ];
        }
        if ($leaveForce !== $existingLeaveForce) {
            $changes['Leave_Force'] = [
                'old' => $existingLeaveForce,
                'new' => $leaveForce
            ];
        }
        if ($leaveSpecial !== $existingLeaveSpecial) {
            $changes['Leave_Special'] = [
                'old' => $existingLeaveSpecial,
                'new' => $leaveSpecial
            ];
        }
        if ($employees_remarks !== $existingRemarks) {
            $changes['employees_remarks'] = [
                'old' => $existingRemarks,
                'new' => $employees_remarks
            ];
        }

        // Prepare and execute the query to update the department
        $query = "UPDATE employees SET  employees_FirstName = ?, 
                                        employees_MiddleName = ?, 
                                        employees_LastName = ?,
                                        employees_sex = ?,
                                        employees_birthdate = ?,
                                        employees_Department = ?,
                                        employees_appointmentDate = ?,
                                        Leave_Vacation = ?,
                                        Leave_Sick = ?,
                                        Leave_Force = ?,
                                        Leave_Special = ?,
                                        employees_remarks = ?
                                        WHERE uID = ? ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "ssssssssssssi",
            $firstName,
            $middleName,
            $lastName,
            $sex,
            $birthdate,
            $departmentId,
            $appointmentDate,
            $leaveVacation,
            $leaveSick,
            $leaveForce,
            $leaveSpecial,
            $employees_remarks,
            $uid
        );

        // Execute the query and check for errors
        if ($stmt->execute()) {
            // Check if any rows were affected
            if ($stmt->affected_rows > 0) {
                // Department updated successfully

                // Log each individual change
                session_start();
                $action = 'edited';
                $toWhom = $existingUID;

                foreach ($changes as $field => $change) {
                    $what = $field . ': ' . $change['old'] . ' -> ' . $change['new'];

                    $query_log = "INSERT INTO logs (admin_uID, admin_Name, admin_Action, action_what, action_toWhom) VALUES (?, ?, ?, ?, ?)";
                    $stmt_log = $conn->prepare($query_log);
                    $stmt_log->bind_param("issss", $_SESSION['admin_uID'], $_SESSION['admin_FirstName'], $action, $what, $toWhom);

                    if ($stmt_log->execute()) {
                        // Log entry added successfully
                        $response = ['success' => true];
                    } else {
                        // Failed to add log entry
                        $response = ['success' => false];
                    }

                    $stmt_log->close();
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

        // Close the statement
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

// Close the database connection
$conn->close();

echo json_encode(['response' => $response]);
