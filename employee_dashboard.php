<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['employee_uID'])) {
    // Redirect the user to the login page or show access denied message
    header('Location: error.401-employee.php');
    exit();
}

// Logout functionality
if (isset($_GET['logout'])) {
    // Perform logout actions
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session

    // Redirect to the login page or any other desired page
    header('Location: employee-login.php');
    exit();
}
?>

<!-- HTML content -->
<p>Welcome, <?php echo $_SESSION['employee_FirstName']; ?>!</p>
<a href="?logout=true">Logout</a>
