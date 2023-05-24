<?php
// query_employee.php

// Include the necessary database connection file
include('includes/dbh.inc.php');

// Check if the employeeID parameter exists in the POST data
if (isset($_POST['employeeID'])) {
    // Get the employee ID from the POST data
    $employeeID = $_POST['employeeID'];

    // Prepare and execute the SQL query to fetch the employee information
    $query = "SELECT * FROM employees WHERE employees_uid = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $employeeID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if any rows were returned
    if (mysqli_num_rows($result) > 0) {
        // Fetch the employee information from the result set
        $employee = mysqli_fetch_assoc($result);

        // Insert the employee information into the admins table
        $insertQuery = "INSERT INTO admins (adminsUid, adminsFirstName, adminsMiddleName, adminsLastName, adminsSex, adminsBirthdate, adminsDepartment, adminsEmail, adminsPassword, adminsRoleId, adminsRole) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insertStmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($insertStmt, "sssssssssis", $employee['employees_uid'], $employee['employees_FirstName'], $employee['employees_MiddleName'], $employee['employees_LastName'], $employee['sex'], $employee['birthdate'], $employee['department'], $employee['email'], $employee['password'], $employee['role_id'], $employee['role']);
        mysqli_stmt_execute($insertStmt);

        // Check if the insert was successful
        if (mysqli_stmt_affected_rows($insertStmt) > 0) {
            // Return a success message
            header('Content-Type: application/json');
            echo json_encode(array('message' => 'Admin added successfully'));
        } else {
            // Return an error message if the insert failed
            header('HTTP/1.1 500 Internal Server Error');
            echo "Error adding admin.";
        }
    } else {
        // Return an error message if the employee was not found
        header('HTTP/1.1 404 Not Found');
        echo "Employee not found.";
    }
} else {
    // Return an error message if the employeeID parameter is missing
    header('HTTP/1.1 400 Bad Request');
    echo "Invalid request. Employee ID parameter is missing.";
}
