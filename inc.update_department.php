<?php

include('includes/dbh.inc.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // check if the required data is provided
    if (isset($_POST['acronym']) && isset($_POST['department']) && isset($_POST['uid'])) {
        $acronym = $_POST['acronym'];
        $department = $_POST['department'];
        $uid = $_POST['uid'];


        // prepare and execute the query to update the department
        $query = "UPDATE departments SET dept_Description = ?, dept_uid = ? WHERE uID = ? ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $department, $acronym, $uid);

        // execute the query and check for errors
        if ($stmt->execute()) {
            // check if any rows were affected
            if ($stmt->affected_rows > 0) {
                // Department updated successfully
                $response = ['success' => true];
            } else {
                // Department not found or no changes made
                $response = ['success' => false, 'message' => 'Department not found or no changes made.'];
            }
        } else {
            // Failed to execute the query
            $response = ['success' => false, 'message' => $conn->error];
        }

        // close the statement
        $stmt->close();
    } else {
        $response = "Missing required parameters.";
    }
} else {
    $response = "Invalid request method.";
}

// close the database connection
$conn->close();

echo json_encode(['response' => $response]);
