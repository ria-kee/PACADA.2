<?php
session_start();
$allowedPages = ['employee_dashboard.php', 'employee_history.php', 'employee_timeoff.php']; // List of allowed pages

$currentFile = basename($_SERVER['PHP_SELF']); // Get the name of the current PHP file

// Check if the user is not logged in and the current page is not in the allowed pages list
if (!isset($_SESSION['employee_uID']) && !in_array($currentFile, $allowedPages)) {
    // Redirect the user to the login page or show access denied message
    header('Location: error.401-employee.php');
    exit();
}
?>

<?php include_once "header_employee/emp.active_profile.php"; ?>
