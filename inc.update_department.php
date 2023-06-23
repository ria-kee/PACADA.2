<?php

include('includes/dbh.inc.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // check if the required data is provided
    if (isset($_POST['acronym']) && isset($_POST['department']) && isset($_POST['uid'])) {
        $acronym = $_POST['acronym'];
        $department = $_POST['department'];
        $uid = $_POST['uid'];


        // prepare and execute the query to update the department
        $query = "UPDATE departments SET dept_Description = ?, dept_uid = ? WHERE uID = ? ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $department, $acronym, $uid);

        // execute the query and check for errors
        if ($stmt->execute()) {
            // check if any rows were affected
            if ($stmt->affected_rows > 0) {
                // Department updated successfully
                session_start();
                $action = 'edited';
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




                $response = ['success' => true];
            } else {
                // Department not found or no changes made
                $response = ['success' => false, 'message' => 'Department not found or no changes made.'];
            }
        } else {
            // Failed to execute the query
            $response = ['success' => false, 'message' => $conn->error];
        }

        // close the statement
        $stmt->close();
    } else {
        $response = "Missing required parameters.";
    }
} else {
    $response = "Invalid request method.";
}

// close the database connection
$conn->close();

echo json_encode(['response' => $response]);
