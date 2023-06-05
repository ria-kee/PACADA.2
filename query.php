<?php
// Include the dbh.inc.php file
include('includes/dbh.inc.php');

// Get the department UID from the script
$departmentUid = $_GET['department'];

// Execute the MySQL query
$query = "SELECT dept_uid FROM departments WHERE uID = '$departmentUid'";
$result = mysqli_query($conn, $query);

// Process the query result
if ($result && mysqli_num_rows($result) > 0) {
    // Fetch the department name
    $row = mysqli_fetch_assoc($result);
    $departmentName = $row['dept_uid'];

    // Output the result
    echo $departmentName;
} else {
    // No department found or query execution failed
    echo 'Department not found.';
}

// Close the database connection
mysqli_close($conn);
