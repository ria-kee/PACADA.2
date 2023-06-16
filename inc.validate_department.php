<?php

include('includes/dbh.inc.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required data is provided
    if (isset($_POST['acronym'])) {
        $acronym = $_POST['acronym'];

        // Check if the acronym already exists in the database
        $query = "SELECT COUNT(*) AS count FROM departments WHERE dept_uid = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $acronym);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];

        if ($count > 0) {
            // Acronym already exists in the database
            $response = ['exists' => true];
        } else {
            // Acronym is valid
            $response = ['exists' => false];
        }

        $stmt->close();
    } else {
        // Missing required parameter
        $response = ['error' => 'Missing acronym parameter.'];
    }
} else {
    // Invalid request method
    $response = ['error' => 'Invalid request method.'];
}

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response);
