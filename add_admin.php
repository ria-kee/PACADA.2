<?php

include('includes/dbh.inc.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // check if the required data is provided
    if (isset($_POST['employeeID']) && isset($_POST['isAdmin'])) {
        $employeeID = $_POST['employeeID'];
        $isAdmin = $_POST['isAdmin'];

        // prepare and execute the query to update the employee's is_admin value
        $query = "UPDATE employees SET is_admin = ? WHERE employees_uid = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("is", $isAdmin, $employeeID);
        $stmt->execute();

        // check if the update was successful
        if ($stmt->affected_rows > 0) {
            echo "Employee is_admin value updated successfully.";
        } else {
            echo "Failed to update employee is_admin value.";
        }

        // close the statement and database connection
        $stmt->close();
        $conn->close();
    } else {
        echo "Missing employeeID or isAdmin parameter.";
    }
} else {
    echo "Invalid request method.";
}
