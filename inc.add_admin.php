<?php

include('includes/dbh.inc.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // check if the required data is provided
    if (isset($_POST['employeeID']) && isset($_POST['isAdmin'])) {
        $employeeID = $_POST['employeeID'];
        $isAdmin = $_POST['isAdmin'];

        // prepare and execute the query to update the employee's is_admin value
        $query = "UPDATE employees SET is_admin = ? WHERE employees_uid = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("is", $isAdmin, $employeeID);
        $stmt->execute();

        // check if the update was successful
        if ($stmt->affected_rows > 0) {

            session_start();
            $action = 'added';
            $what = 'admin:';

            $query_log = "INSERT INTO logs (admin_uID, admin_Name, admin_Action, action_what, action_toWhom) VALUES (?, ?, ?, ?, ?)";
            $stmt_log = $conn->prepare($query_log);
            $stmt_log->bind_param("issss", $_SESSION['admin_uID'], $_SESSION['admin_FirstName'], $action, $what, $employeeID);

            if ($stmt_log->execute()) {
                // Department and log entry added successfully
                $response = ['success' => true];
            } else {
                // Failed to add log entry
                $response = ['success' => false];
            }

            $stmt_log->close();
            echo "Employee is assigned as admin successfully.";
        } else {
            echo "Failed to update employee is_admin value.";
        }

        // close the statement and database connection
        $stmt->close();
        $conn->close();
    } else {
        echo "Missing employeeID or isAdmin parameter.";
    }
} else {
    echo "Invalid request method.";
}
