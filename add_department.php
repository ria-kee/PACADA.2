<?php

include('includes/dbh.inc.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required data is provided
    if (isset($_POST['acronym']) && isset($_POST['department'])) {
        $acronym = $_POST['acronym'];
        $department = $_POST['department'];

        // Insert the department into the database
        $query = "INSERT INTO departments (dept_uid, dept_Description) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $acronym, $department);

        if ($stmt->execute()) {
            // Department added successfully
            $response = ['success' => true];
        } else {
            // Failed to add department
            $response = ['success' => false];
        }

        $stmt->close();
    } else {
        // Missing required parameters
        $response = ['error' => 'Missing acronym or department parameter.'];
    }
} else {
    // Invalid request method
    $response = ['error' => 'Invalid request method.'];
}

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response);
