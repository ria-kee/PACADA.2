<?php
//Include config file
include_once 'config.php';

$conn = mysqli_connect($hostname, $username, $password, $database);

// Check the connection
if (!$conn) {
    echo "Failed to connect to the database: " . mysqli_connect_error();
    exit;
}

// Connection successful
echo "Connected to the database successfully!";

// Perform your desired operations using the $conn object

// Close the connection when done
mysqli_close($conn);