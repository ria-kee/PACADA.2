<?php
include('includes/dbh.inc.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the employee ID from the POST data
    $employeeID = $_POST['employees_ID'];

    // Perform the database update
    $sql = "UPDATE employees SET is_admin = 0 WHERE employees_uid = '$employeeID'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Return a success message
        echo "Admin removed successfully!";
    } else {
        // Return an error message
        echo "Failed to remove admin.";
    }
} else {
    // Return an error message if the request method is not POST
    echo "Invalid request!";
}
