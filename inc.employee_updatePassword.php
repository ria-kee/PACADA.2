<?php
include('includes/dbh.inc.php');

// Retrieve the new password from the AJAX request
$newPassword = $_POST['new'];

// Validate and update the password
if (!empty($newPassword)) {
    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Retrieve the employee record based on the admin_uID from the session
    $query = "SELECT uID FROM employees WHERE uID = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        exit();
    }

    // Retrieve the admin_uID from the session
    session_start();
    $emp_uID =  $_SESSION['employee_uID'];

    // Bind the parameter and execute the query
    $stmt->bind_param("s", $emp_uID);
    $stmt->execute();

    // Check if the employee exists
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        // Update the password for the employee
        $updateQuery = "UPDATE employees SET employees_Password = ? WHERE uID = ?";
        $updateStmt = $conn->prepare($updateQuery);

        if (!$updateStmt) {
            echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
            exit();
        }

        // Bind the parameters and execute the update query
        $updateStmt->bind_param("ss", $hashedPassword, $emp_uID);
        $updateStmt->execute();

        // Check if the password update was successful
        if ($updateStmt->affected_rows > 0) {
            // Password update successful
            echo 'success';
        } else {
            // Password update failed
            echo 'error';
        }

        $updateStmt->close();
    } else {
        // Employee record not found
        echo 'error';
    }

    $stmt->close();
    $conn->close();
} else {
    // New password is empty
    echo 'error';
}
