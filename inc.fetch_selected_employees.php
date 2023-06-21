<?php
include('includes/dbh.inc.php');

// Get the department ID from the query string parameter
$departmentId = $_GET['departmentId'];

if ($departmentId==0){
    // Perform the query to retrieve the employees
    $query = mysqli_query($conn, "SELECT * FROM employees WHERE is_active=1");
} else{
    // Perform the query to retrieve the employees based on the department ID
    $query = mysqli_query($conn, "SELECT * FROM employees WHERE employees_Department = '$departmentId' AND is_active=1");

}

$employees = array();

while ($row = mysqli_fetch_assoc($query)) {
    $empName = ucwords(strtolower($row['employees_FirstName'])) . ' ';

    if (!empty($row['employees_MiddleName'])) {
        $empName .= strtoupper(substr($row['employees_MiddleName'], 0, 1)) . '. ';
    }
    $empName .= ucwords(strtolower($row['employees_LastName']));

    $employee = array(
        'id' => $row['uID'],
        'name' => $empName
    );
    $employees[] = $employee;
}

// Return the employees as JSON response
header('Content-Type: application/json');
echo json_encode($employees);

