<?php

include('includes/dbh.inc.php');

// Retrieve the employee data from the regular form fields
$uid = $_POST['employees_uid'];
$firstName = $_POST['employees_FirstName'];
$middleName = $_POST['employees_MiddleName'];
$lastName = $_POST['employees_LastName'];
$sex = $_POST['employees_sex'];
$birthdate = $_POST['employees_birthdate'];
$departmentId = $_POST['employees_Department'];
$appointmentDate = $_POST['employees_appointmentDate'];
$leaveVacation = $_POST['Leave_Vacation'];
$leaveSick = $_POST['Leave_Sick'];
$leaveForce = $_POST['Leave_Force'];
$leaveSpecial = $_POST['Leave_Special'];
$email = $_POST['employees_Email'];
$password = $_POST['employees_Password'];

// Retrieve the employee image file
$image = $_FILES['employees_image'];

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Retrieve the original file name
$blobName = $_FILES['employees_image']['name'];

// Move the uploaded image file to a permanent location
$targetDirectory = 'assets/profiles/';
$imageExtension = pathinfo($blobName, PATHINFO_EXTENSION);
$imageName = $uid. '.' . $imageExtension;
$targetFileName = $targetDirectory . $imageName;
move_uploaded_file($_FILES['employees_image']['tmp_name'], $targetFileName);
$imageContent = file_get_contents($targetFileName);
// Create a Blob object
$blob = new stdClass();
$blob->type = mime_content_type($targetFileName);
$blob->data = base64_encode($imageContent);
$blobbed = $blob->data;

// Prepare the SQL statement
$sql = 'INSERT INTO employees (employees_uid, employees_image, employees_FirstName, employees_MiddleName, employees_LastName,
                      employees_sex, employees_birthdate, employees_Department, employees_appointmentDate,
                      Leave_Vacation, Leave_Sick, Leave_Force, Leave_Special, employees_Email, employees_Password, 
                       is_active, is_admin, is_superadmin)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

// Prepare the statement and bind the parameters
$stmt = $conn->prepare($sql);

$is_active = 1;
$is_admin = 0;
$is_superadmin = 0;

// Bind the values to the placeholders
$stmt->bind_param(
    'sssssssisddddssiii',
    $uid,
    $blobbed,
    $firstName,
    $middleName,
    $lastName,
    $sex,
    $birthdate,
    $departmentId,
    $appointmentDate,
    $leaveVacation,
    $leaveSick,
    $leaveForce,
    $leaveSpecial,
    $email,
    $hashedPassword,
    $is_active,
    $is_admin,
    $is_superadmin
);

// Execute the statement
if ($stmt->execute()) {
    // Insertion successful
    echo "Employee is added successfully.";
} else {
    // Insertion failed
    echo "Failed to add new employee.";
}

// Close the statement and the database connection
$stmt->close();
$conn->close();
