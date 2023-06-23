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
        session_start();
        $action = 'removed';
        $what = 'admin:';

        $query_log = "INSERT INTO logs (admin_uID, admin_Name, admin_Action, action_what, action_toWhom) VALUES (?, ?, ?, ?, ?)";
        $stmt_log = $conn->prepare($query_log);
        $stmt_log->bind_param("issss", $_SESSION['admin_uID'], $_SESSION['admin_FirstName'], $action, $what, $employeeID);

        if ($stmt_log->execute()) {
            // Department and log entry added successfully
            $response = ['success' => true];
        } else {
            // Failed to add log entry
            $response = ['success' => false];
        }
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
