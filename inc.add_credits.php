<?php
include('includes/dbh.inc.php');

// Retrieve the data sent through the AJAX request
$uID = $_POST['uID'];
$vacationValue = $_POST['vacation'];
$sickValue = $_POST['sick'];

// Update the employees table with the new credit values
$sql = "UPDATE employees SET Leave_Vacation = ?, Leave_Sick = ?, credit_updateDate = NOW(), credit_isUpdated = 1 WHERE uID = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('dds', $vacationValue, $sickValue, $uID);

if ($stmt->execute()) {
            // Department added successfully
            $response = ['success' => true];
        } else {
            // Failed to add department
            $response = ['success' => false];
        }

        $stmt->close();


