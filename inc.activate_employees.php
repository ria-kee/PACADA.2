<?php

include('includes/dbh.inc.php');
session_start();
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the department IDs from the POST data
    $empIds = $_POST['empIds'];

    // activation
    $successCount = 0;
    $errorCount = 0;
    $errorMessages = array();

    foreach ($empIds as $empId) {
        // Perform the deletion query
        $sql = "UPDATE employees SET is_active = 1 WHERE uID = '$empId'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $action = 'activated';
            $what = 'employee';

            $query_findEmp = "SELECT employees_uid FROM employees WHERE uID='$empId'";
            $result_found = mysqli_query($conn, $query_findEmp);

            if ($result_found) {
                $row = mysqli_fetch_assoc($result_found);
                $emp_id = $row['employees_uid'];
            }

            $query_log = "INSERT INTO logs (admin_uID, admin_Name, admin_Action, action_what, action_toWhom) VALUES (?, ?, ?, ?, ?)";
            $stmt_log = $conn->prepare($query_log);
            $stmt_log->bind_param("issss", $_SESSION['admin_uID'], $_SESSION['admin_FirstName'], $action, $what, $emp_id);

            if ($stmt_log->execute()) {
                // Increment the success count
                $successCount++;
            } else {
                // Increment the error count and store the error message
                $errorCount++;
                $errorMessages[] = "Failed to add log entry for department with ID $deptId: " . mysqli_error($conn);
            }
        } else {
            // Increment the error count and store the error message
            $errorCount++;
            $errorMessages[] = "Failed to activate employee with ID $deptId: " . mysqli_error($conn);
        }
    }

    // Check if any errors occurred during the deletion
    if ($errorCount > 0) {
        // Return an error message with the count and individual error messages
        http_response_code(500); // Set the HTTP response code to indicate an error
        echo "Failed to activate $errorCount employee(s).";
        echo " Error message(s): " . implode(' ', $errorMessages);
    } else {
        // Return a success message with the count
        echo "Successfully activated $successCount employee(s).";
    }
} else {
    // Return an error message if the request method is not POST
    echo "Invalid request!";
}
