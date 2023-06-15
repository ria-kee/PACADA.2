<?php
session_start();
$allowedPages = ['dashboard.php', 'departments.php', 'leave.php',
    'leave.php', 'admins.php', 'profile.php',
    'archived_departments.php', 'archived_employees.php']; // List of allowed pages

$currentFile = basename($_SERVER['PHP_SELF']); // Get the name of the current PHP file

// Check if the user is not logged in and the current page is not in the allowed pages list
if (!isset($_SESSION['admin_uID']) && !in_array($currentFile, $allowedPages)) {
    // Redirect the user to the login page or show access denied message
    header('Location: error.401.php');
    exit();
}
?>
<?php include_once "header/active_time-off.php";?>