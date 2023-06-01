<?php
include('includes/dbh.inc.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the department ID and acronym from the POST data
    $deptId = $_POST['uID'];
    $acronym = $_POST['acronym'];

    // Perform the deletion query
    $sql_delete = "DELETE FROM departments WHERE uID = '$deptId'";
    $result_delete = mysqli_query($conn, $sql_delete);

    if ($result_delete) {
        // Return a success message
        echo "<b>$acronym</b> Department deleted successfully.";
    } else {
        // Return an error message
        http_response_code(500); // Set the HTTP response code to indicate an error
        echo "Failed to delete department with ID $deptId: " . mysqli_error($conn);
    }
} else {
    // Return an error message if the request method is not POST
    echo "Invalid request!";
}
