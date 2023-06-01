<?php

include('includes/dbh.inc.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the department IDs from the POST data
    $deptIds = $_POST['deptIds'];

    // Perform the deletion action here
    // You can connect to your database and execute the necessary queries

    // Example: Deleting departments from the database
    $successCount = 0;
    $errorCount = 0;
    $errorMessages = array();

    foreach ($deptIds as $deptId) {
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
