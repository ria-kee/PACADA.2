<?php

include('includes/dbh.inc.php');
session_start();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the department IDs from the POST data
    $deptIds = $_POST['deptIds'];

    // Deactivation
    $successCount = 0;
    $errorCount = 0;
    $errorMessages = array();

    foreach ($deptIds as $deptId) {
        // Perform the database update
        $sql_update = "UPDATE departments SET is_active = 1 WHERE uID = '$deptId'";
        $result_update = mysqli_query($conn, $sql_update);

        if ($result_update) {

            $action = 'activated';
            $what = 'department';

            $query_findDept = "SELECT dept_uid FROM departments WHERE uID='$deptId'";
            $result_found = mysqli_query($conn, $query_findDept);

            if ($result_found) {
                $row = mysqli_fetch_assoc($result_found);
                $acronym = $row['dept_uid'];
            }

            $query_log = "INSERT INTO logs (admin_uID, admin_Name, admin_Action, action_what, action_toWhom) VALUES (?, ?, ?, ?, ?)";
            $stmt_log = $conn->prepare($query_log);
            $stmt_log->bind_param("issss", $_SESSION['admin_uID'], $_SESSION['admin_FirstName'], $action, $what, $acronym);

            if ($stmt_log->execute()) {
                // Increment the success count
                $successCount++;
            } else {
                // Increment the error count and store the error message
                $errorCount++;
                $errorMessages[] = "Failed to add log entry for department with ID $deptId: " . mysqli_error($conn);
            }
        } else {
            // Increment the error count and store the error message
            $errorCount++;
            $errorMessages[] = "Failed to activate department with ID $deptId: " . mysqli_error($conn);
        }
    }

    // Check if any errors occurred during the deactivation
    if ($errorCount > 0) {
        // Return an error message with the count and individual error messages
        http_response_code(500); // Set the HTTP response code to indicate an error
        echo "Failed to deactivate $errorCount department(s).";
        echo " Error message(s): " . implode(' ', $errorMessages);
    } else {
        // Return a success message with the count
        echo "Successfully activated $successCount department(s).";
    }
} else {
    // Return an error message if the request method is not POST
    echo "Invalid request!";
}
