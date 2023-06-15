<?php
session_start();

// Check if the admin first name is set in the session
if (isset($_SESSION['admin_FirstName'])) {
    // Retrieve the admin first name from the session
    $adminFirstName = $_SESSION['admin_FirstName'];

    // Send the admin first name as the response
    echo $adminFirstName;
} else {
    // Admin first name is not set in the session
    // Return an error or appropriate response
    echo 'Admin first name not found';
}
