<?php

include('includes/dbh.inc.php');
// Retrieve the selected employee ID from the GET request
$employeeId = $_GET['employeeId'];


// Prepare the SQL query to fetch the employee information based on the employee ID
$sql = "SELECT  uID, employees_FirstName, employees_MiddleName, employees_LastName,
        employees_Department, employees_image, Leave_Vacation, Leave_Sick, Leave_Force, Leave_Special  FROM employees WHERE uID = '$employeeId'";

// Execute the query
$result = $conn->query($sql);

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Fetch the employee information from the result set
    $employee = $result->fetch_assoc();

    // Convert the employee information to JSON format
    $jsonResponse = json_encode($employee);

    // Set the appropriate headers to indicate that the response contains JSON data
    header('Content-Type: application/json');

    // Send the JSON response back to the client
    echo $jsonResponse;
} else {
    // If no employee was found, you can return an empty response or an error message
    echo json_encode(array('error' => 'Employee not found'));
}

// Close the database connection
$conn->close();

