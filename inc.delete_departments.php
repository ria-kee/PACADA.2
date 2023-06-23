<?php

include('includes/dbh.inc.php');
session_start();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the department IDs from the POST data
    $deptIds = $_POST['deptIds'];

    // Deletion
    $successCount = 0;
    $errorCount = 0;
    $errorMessages = array();

    foreach ($deptIds as $deptId) {
        // Retrieve the department details for logging
        $query_findDept = "SELECT dept_uid FROM departments WHERE uID='$deptId'";
        $result_found = mysqli_query($conn, $query_findDept);

        if ($result_found && mysqli_num_rows($result_found) > 0) {
            $row = mysqli_fetch_assoc($result_found);
            $acronym = $row['dept_uid'];

            // Log the deletion
            $action = 'deleted';
            $what = 'department';
            $query_log = "INSERT INTO logs (admin_uID, admin_Name, admin_Action, action_what, action_toWhom) VALUES (?, ?, ?, ?, ?)";
            $stmt_log = $conn->prepare($query_log);
            $stmt_log->bind_param("issss", $_SESSION['admin_uID'], $_SESSION['admin_FirstName'], $action, $what, $acronym);
            $stmt_log->execute();
            $stmt_log->close();

            // Perform the deletion query
            $sql_delete = "DELETE FROM departments WHERE uID = '$deptId'";
            $result_delete = mysqli_query($conn, $sql_delete);

            if ($result_delete) {
                // Increment the success count
                $successCount++;
            } else {
                // Increment the error count and store the error message
                $errorCount++;
                $errorMessages[] = "Failed to delete department with ID $deptId: " . mysqli_error($conn);
            }
        } else {
            // Handle case where department details are not found
            $errorCount++;
            $errorMessages[] = "Failed to retrieve department details for ID $deptId.";
        }
    }

    // Check if any errors occurred during the deletion
    if ($errorCount > 0) {
        // Return an error message with the count and individual error messages
        http_response_code(500); // Set the HTTP response code to indicate an error
        echo "Failed to delete $errorCount department(s).";
        echo " Error message(s): " . implode(' ', $errorMessages);
    } else {
        // Return a success message with the count
        echo "Successfully deleted $successCount department(s).";
    }
} else {
    // Return an error message if the request method is not POST
    echo "Invalid request!";
}
