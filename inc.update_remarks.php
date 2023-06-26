<?php

include('includes/dbh.inc.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the department ID from the POST data
    $uID = $_POST['uID'];

    // Get the remarks from the request
    $remarks = $_POST['remarks'];

    // Assuming you have a database connection already established
    // Prepare the update statement
    $sql_update = "UPDATE employees SET timeoff_remarks = ? WHERE uID = ?";
    $stmt = mysqli_prepare($conn, $sql_update);

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, "si", $remarks, $uID);

    // Execute the statement
    $result_update = mysqli_stmt_execute($stmt);

    if ($result_update) {

            session_start();
            $action = 'updated';
            $what = 'time-off remarks of';

            $query_findDept = "SELECT employees_uid FROM employees WHERE uID='$uID'";
            $result_found = mysqli_query($conn, $query_findDept);

            if ($result_found) {
                $row = mysqli_fetch_assoc($result_found);
                $employee = $row['employees_uid'];
            }

            $query_log = "INSERT INTO logs (admin_uID, admin_Name, admin_Action, action_what, action_toWhom) VALUES (?, ?, ?, ?, ?)";
            $stmt_log = $conn->prepare($query_log);
            $stmt_log->bind_param("issss", $_SESSION['admin_uID'], $_SESSION['admin_FirstName'], $action, $what, $employee);

            if ($stmt_log->execute()) {
                // Department and log entry added successfully
                $response = ['success' => true];
            } else {
                // Failed to add log entry
                $response = ['success' => false];
            }

            $stmt_log->close();

            // Return a success message
            echo "Time-Off Remarks updated successfully!";
        } else {
            // Return an error message
            http_response_code(500); // Set the HTTP response code to indicate an error
            echo "Failed to update Time-Off Remarks.";
        }

} else {
    // Return an error message if the request method is not POST
    echo "Invalid request!";
}
