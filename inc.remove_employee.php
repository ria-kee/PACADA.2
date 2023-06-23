<?php

include('includes/dbh.inc.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the department ID from the POST data
    $uID = $_POST['uID'];

    // Check if the department is assigned to any employee
    $sql_check = "SELECT * FROM employees WHERE uID = '$uID' AND is_admin='1' ";
    $result_check = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result_check) > 0) {
        // Return an error message if the department is assigned to an employee
        http_response_code(400); // Set the HTTP response code to indicate an error
        echo "Cannot deactivate employee. Employee is assigned as administrator.";
    } else {
        // Perform the database update
        $sql_update = "UPDATE employees SET is_active = 0 WHERE uID = '$uID'";
        $result_update = mysqli_query($conn, $sql_update);

        if ($result_update) {
            session_start();
            $action = 'deactivated';
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


            // Return a success message
            echo "Employee deactivated successfully!";
        } else {
            // Return an error message
            http_response_code(500); // Set the HTTP response code to indicate an error
            echo "Failed to deactivate department.";
        }
    }

} else {
    // Return an error message if the request method is not POST
    echo "Invalid request!";
}
