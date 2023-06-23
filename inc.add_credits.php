<?php
include('includes/dbh.inc.php');
session_start();

// Retrieve the data sent through the AJAX request
$uID = $_POST['uID'];
$vacationValue = $_POST['vacation'];
$sickValue = $_POST['sick'];
$late = $_POST['late'];

// Update the employees table with the new credit values
$sql = "UPDATE employees SET Leave_Vacation = ?, Leave_Sick = ?, credit_updateDate = NOW(), credit_isUpdated = 1 WHERE uID = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('dds', $vacationValue, $sickValue, $uID);

if ($stmt->execute()) {
    // Department added successfully
    $response = ['success' => true];

    // Log the late update
    $action = 'record';
    $what = 'late: ' . $late;

    $query_findEmp = "SELECT employees_uid FROM employees WHERE uID = ?";
    $stmt_findEmp = $conn->prepare($query_findEmp);
    $stmt_findEmp->bind_param("i", $uID);

    if ($stmt_findEmp->execute()) {
        $stmt_findEmp->store_result();

        if ($stmt_findEmp->num_rows > 0) {
            $stmt_findEmp->bind_result($emp_id);
            $stmt_findEmp->fetch();

            $query_log = "INSERT INTO logs (admin_uID, admin_Name, admin_Action, action_what, action_toWhom) VALUES (?, ?, ?, ?, ?)";
            $stmt_log = $conn->prepare($query_log);
            $stmt_log->bind_param("issss", $_SESSION['admin_uID'], $_SESSION['admin_FirstName'], $action, $what, $emp_id);

            if ($stmt_log->execute()) {
                // Log entry added successfully
            } else {
                // Failed to add log entry
                $response = ['success' => false, 'message' => 'Failed to add log entry.'];
            }

            $stmt_log->close();
        } else {
            // No employee found
            $response = ['success' => false, 'message' => 'No employee found.'];
        }
    } else {
        // Failed to execute query to find employee
        $response = ['success' => false, 'message' => 'Failed to execute query to find employee.'];
    }

    $stmt_findEmp->close();
} else {
    // Failed to update employees table
    $response = ['success' => false, 'message' => 'Failed to update employees table.'];
}

$stmt->close();

echo json_encode(['response' => $response]);
