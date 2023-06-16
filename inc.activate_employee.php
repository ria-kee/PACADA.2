<?php

include('includes/dbh.inc.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the department ID and acronyms from the POST data
    $uID = $_POST['uID'];
    $empname = $_POST['empname'];

    // Perform the database update
    $sql_update = "UPDATE employees SET is_active = 1 WHERE uID = '$uID'";
//    echo "SQL query: $sql_update"; // Debug statement
    $result_update = mysqli_query($conn, $sql_update);

    if ($result_update) {
        // Return a success message with the department acronym
        echo "$empname is activated successfully!";
    } else {
        // Return an error message
        http_response_code(500); // Set the HTTP response code to indicate an error
        echo "Failed to activate employee.";
    }

} else {
    // Return an error message if the request method is not POST
    echo "Invalid request!";
}
