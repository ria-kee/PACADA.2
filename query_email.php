<?php
// Include the dbh.inc.php file
include('includes/dbh.inc.php');

// Get the ID from the GET parameters
$email = $_GET['email'];

// Prepare the SQL query
$query = "SELECT COUNT(*) AS count FROM employees WHERE employees_email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();

// Process the query result
if ($count > 0) {
    // ID already exists
    echo json_encode(['exists' => true]);
} else {
    // ID does not exist
    echo json_encode(['exists' => false]);
}

// Close the statement and the database connection if necessary
$stmt->close();
$conn->close();
