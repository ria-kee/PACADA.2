<?php
// Database connection file
include('includes/dbh.inc.php');

if (isset($_POST['deptId'])) {
    $deptId = $_POST['deptId'];

    // Fetch department details from the database
    $sql = "SELECT * FROM departments WHERE uID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $deptId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the department details as an associative array
        $department = $result->fetch_assoc();

        // Return the department details as a JSON response
        echo json_encode($department);
    } else {
        // Department not found
        echo json_encode(['error' => 'Department not found']);
    }
} else {
    // Invalid request
    echo json_encode(['error' => 'Invalid request']);
}
?>
