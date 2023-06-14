<?php

include('includes/dbh.inc.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the department IDs from the POST data
    $empIds = $_POST['empIds'];

    // activation
    $successCount = 0;
    $errorCount = 0;
    $errorMessages = array();

    foreach ($empIds as $empId) {
        // Perform the deletion query
        $sql = "UPDATE employees SET is_active = 1 WHERE uID = '$empId'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Increment the success count
            $successCount++;
        } else {
            // Increment the error count and store the error message
            $errorCount++;
            $errorMessages[] = "Failed to activate employee with ID $deptId: " . mysqli_error($conn);
        }
    }

    // Check if any errors occurred during the deletion
    if ($errorCount > 0) {
        // Return an error message with the count and individual error messages
        http_response_code(500); // Set the HTTP response code to indicate an error
        echo "Failed to activate $errorCount employee(s).";
        echo " Error message(s): " . implode(' ', $errorMessages);
    } else {
        // Return a success message with the count
        echo "Successfully activated $successCount employee(s).";
    }
} else {
    // Return an error message if the request method is not POST
    echo "Invalid request!";
}
