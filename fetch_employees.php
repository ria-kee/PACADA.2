<?php
include('includes/dbh.inc.php');

// Retrieve the selected department from the AJAX request
$selectedDepartment = $_POST['department'];

// Prepare and execute the query to fetch employees based on the selected department and exclude those in the admins table
$query = "SELECT * FROM employees WHERE employees_Department = ? AND is_admin = 0 AND is_superadmin = 0";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $selectedDepartment);
$stmt->execute();
$result = $stmt->get_result();

// Create an array to store the employee data
$employees = array();

// Fetch the data from the result set and add it to the employees array
while ($row = $result->fetch_assoc()) {
    $employeeID = strtoupper($row['employees_uid']);
    $employee = array(
        'employeeID' => $employeeID
    );

    $employees[] = $employee;
}

// Close the statement and database connection
$stmt->close();
$conn->close();

// Return the employee data as JSON
echo json_encode($employees);
