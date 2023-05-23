<?php
include('includes/dbh.inc.php');

// Assuming you have already established a database connection

// Retrieve the selected department from the AJAX request
$selectedDepartment = $_POST['department'];

// Prepare and execute the query to fetch employees based on the selected department and exclude those in the admins table
$query = "SELECT * FROM employees WHERE employees_Department = ? AND NOT EXISTS (SELECT 1 FROM admins WHERE admins.adminsUid = employees.employees_uid)";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $selectedDepartment);
$stmt->execute();
$result = $stmt->get_result();

// Create an array to store the employee data
$employees = array();

// Fetch the data from the result set and add it to the employees array
while ($row = $result->fetch_assoc()) {
    $employeeName = $row['employees_FirstName'];

    // Check if Middle Name exists and add its initial with a period
    if ($row['employees_MiddleName'] !== null) {
        $middleInitial = strtoupper(substr($row['employees_MiddleName'], 0, 1));
        $employeeName .= ' ' . $middleInitial . '.';
    }

    $employeeName .= ' ' . $row['employees_LastName'];

    // Capitalize the first letter of each word
    $employeeName = ucwords(strtolower($employeeName));

    $employee = array(
        'employeeName' => $employeeName
    );

    $employees[] = $employee;
}

// Close the statement and database connection
$stmt->close();
$conn->close();

// Return the employee data as JSON
echo json_encode($employees);

