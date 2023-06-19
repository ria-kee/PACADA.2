<?php
session_start();
include('includes/dbh.inc.php');

// retrieve the current password from the AJAX request
$currentPassword = $_POST['current'];

// Retrieve the employee record based on the admin_uID from the session
$query = "SELECT employees_Password FROM employees WHERE uID = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
    exit();
}

//  the admin_uID is stored in the $_SESSION['admin_uID'] variable
$admin_uID =  $_SESSION['admin_uID'];

// Bind the parameter and execute the query
$stmt->bind_param("s", $admin_uID);
$stmt->execute();

// Get the result
$stmt->bind_result($hashedPassword);
$stmt->fetch();

// Send the response back to the client
if (password_verify($currentPassword, $hashedPassword)) {
    echo 'valid';
} else {
    echo 'invalid';

}

// Close the statement
$stmt->close();
