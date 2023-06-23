<?php

include('includes/dbh.inc.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the department ID and acronyms from the POST data
    $uID = $_POST['uID'];
    $empname = $_POST['empname'];

    // Perform the database update
    $sql_update = "UPDATE employees SET is_active = 1 WHERE uID = '$uID'";
//    echo "SQL query: $sql_update"; // Debug statement
    $result_update = mysqli_query($conn, $sql_update);

    if ($result_update) {

        session_start();
        $action = 'activated';
        $what = 'employee';

        $query_findEmp = "SELECT employees_uid FROM employees WHERE uID='$uID'";
        $result_found = mysqli_query($conn, $query_findEmp);

        if ($result_found) {
            $row = mysqli_fetch_assoc($result_found);
            $emp_id = $row['employees_uid'];
        }

        $query_log = "INSERT INTO logs (admin_uID, admin_Name, admin_Action, action_what, action_toWhom) VALUES (?, ?, ?, ?, ?)";
        $stmt_log = $conn->prepare($query_log);
        $stmt_log->bind_param("issss", $_SESSION['admin_uID'], $_SESSION['admin_FirstName'], $action, $what, $emp_id);

        if ($stmt_log->execute()) {
            // Department and log entry added successfully
            $response = ['success' => true];
        } else {
            // Failed to add log entry
            $response = ['success' => false];
        }

        $stmt_log->close();

        // Return a success message with the department acronym
        echo "$empname is activated successfully!";
    } else {
        // Return an error message
        http_response_code(500); // Set the HTTP response code to indicate an error
        echo "Failed to activate employee.";
    }

} else {
    // Return an error message if the request method is not POST
    echo "Invalid request!";
}
