<?php

include('includes/dbh.inc.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required data is provided
    if (isset($_POST['acronym']) && isset($_POST['department'])) {
        $acronym = $_POST['acronym'];
        $department = $_POST['department'];
        $active = 1;

        // Insert the department into the database
        $query = "INSERT INTO departments (dept_uid, dept_Description, is_active) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $acronym, $department, $active);

        if ($stmt->execute()) {
            session_start();
            $action = 'added';
            $what = 'department';

            $query_log = "INSERT INTO logs (admin_uID, admin_Name, admin_Action, action_what, action_toWhom) VALUES (?, ?, ?, ?, ?)";
            $stmt_log = $conn->prepare($query_log);
            $stmt_log->bind_param("issss", $_SESSION['admin_uID'], $_SESSION['admin_FirstName'], $action, $what, $acronym);

            if ($stmt_log->execute()) {
                // Department and log entry added successfully
                $response = ['success' => true];
            } else {
                // Failed to add log entry
                $response = ['success' => false];
            }

            $stmt_log->close();
        } else {
            // Failed to add department
            $response = ['success' => false];
        }

        $stmt->close();
    } else {
        // Missing required parameters
        $response = ['error' => 'Missing acronym or department parameter.'];
    }
} else {
    // Invalid request method
    $response = ['error' => 'Invalid request method.'];
}

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response);
