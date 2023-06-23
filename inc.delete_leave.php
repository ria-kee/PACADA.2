<?php
include('includes/dbh.inc.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the department ID and acronym from the POST data
    $id = $_POST['id'];
    $empname = $_POST['employee'];
    $leaveType = $_POST['type'];
    $empID = $_POST['employee_id'];

    // Fetch employee information from the database
    $query_employee = "SELECT * FROM employees WHERE uID = $empID";
    $result_employee = mysqli_query($conn, $query_employee);

    if ($result_employee) {
        $row = mysqli_fetch_assoc($result_employee);
        // Access individual columns and assign them to variables
        $currentVacation = $row['Leave_Vacation'];
        $currentSick = $row['Leave_Sick'];
        $currentForce = $row['Leave_Force'];
        $currentSpl = $row['Leave_Special'];

        $updateSuccessful = false; // Variable to track if the update was successful

        if ($leaveType === 'Vacation') {
            $updatedVacation = $currentVacation + 1;
            $query = "UPDATE employees SET Leave_Vacation = ? WHERE uID = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "si", $updatedVacation, $empID);
            // Execute the prepared statement
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                $updateSuccessful = true;
            } else {
                // Handle the database error
                $errorMessage = mysqli_error($conn);
                echo "Error: " . $errorMessage;
                exit;
            }
        } elseif ($leaveType === 'Sick') {
            $updatedSick = $currentSick + 1;
            $query = "UPDATE employees SET Leave_Sick = ? WHERE uID = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "si", $updatedSick, $empID);
            // Execute the prepared statement
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                $updateSuccessful = true;
            } else {
                // Handle the database error
                $errorMessage = mysqli_error($conn);
                echo "Error: " . $errorMessage;
                exit;
            }
        } elseif ($leaveType === 'Force') {
            $updatedForce = $currentForce + 1;
            $query = "UPDATE employees SET Leave_Force = ? WHERE uID = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "si", $updatedForce, $empID);
            // Execute the prepared statement
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                $updateSuccessful = true;
            } else {
                // Handle the database error
                $errorMessage = mysqli_error($conn);
                echo "Error: " . $errorMessage;
                exit;
            }
        } elseif ($leaveType === 'Special') {
            $updatedSpecial = $currentSpl + 1;
            $query = "UPDATE employees SET Leave_Special = ? WHERE uID = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "si", $updatedSpecial, $empID);
            // Execute the prepared statement
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                $updateSuccessful = true;
            } else {
                // Handle the database error
                $errorMessage = mysqli_error($conn);
                echo "Error: " . $errorMessage;
                exit;
            }
        } elseif ($leaveType === 'Others') {
            $updateSuccessful = true;
        }

        if ($updateSuccessful) {
            // Perform the deletion query
            $sql_delete = "DELETE FROM leaves WHERE uID = '$id'";
            $result_delete = mysqli_query($conn, $sql_delete);

            if ($result_delete) {
                // Return a success message
                echo "<b>$empname</b> leave is canceled successfully.";
            } else {
                // Return an error message
                http_response_code(500); // Set the HTTP response code to indicate an error
                echo "Failed to cancel leave of $empname: " . mysqli_error($conn);
            }
        } else {
            // Return an error message if the update was not successful
            echo "Failed to update leave for $empname.";
        }
    } else {
        // Return an error message if the employee data retrieval failed
        echo "Failed to fetch employee data for $empname.";
    }
} else {
    // Return an error message if the request method is not POST
    echo "Invalid request!";
}
