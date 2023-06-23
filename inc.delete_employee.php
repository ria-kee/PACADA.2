<?php
include('includes/dbh.inc.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the department ID and acronym from the POST data
    $id = $_POST['id'];
    $empid = $_POST['empid'];
    $empname = $_POST['empname'];

    // Perform the deletion query
    $sql_delete = "DELETE FROM employees WHERE uID = '$id'";
    $result_delete = mysqli_query($conn, $sql_delete);

    if ($result_delete) {
        session_start();
        $action = 'deleted';
        $what = 'employee';

        $query_log = "INSERT INTO logs (admin_uID, admin_Name, admin_Action, action_what, action_toWhom) VALUES (?, ?, ?, ?, ?)";
        $stmt_log = $conn->prepare($query_log);
        $stmt_log->bind_param("issss", $_SESSION['admin_uID'], $_SESSION['admin_FirstName'], $action, $what, $empid);

        if ($stmt_log->execute()) {
            // Department and log entry added successfully
            $response = ['success' => true];
        } else {
            // Failed to add log entry
            $response = ['success' => false];
        }

        $stmt_log->close();
        // Return a success message
        echo "<b>$empid : $empname</b> Department deleted successfully.";
    } else {
        // Return an error message
        http_response_code(500); // Set the HTTP response code to indicate an error
        echo "Failed to delete department with ID $empid: " . mysqli_error($conn);
    }
} else {
    // Return an error message if the request method is not POST
    echo "Invalid request!";
}
