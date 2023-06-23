<?php
include('includes/dbh.inc.php');
session_start();

// Get the values from the AJAX request
$leaveDates = $_POST['LeaveDates'];
$leaveDays = $_POST['LeaveDays'];
$uID = $_POST['uID'];
$dept = $_POST['dept'];
$leaveType = $_POST['type'];
$currentVacation = $_POST['current_vacation'];
$currentSick = $_POST['current_sick'];
$currentForce = $_POST['current_force'];
$currentSpl = $_POST['current_spl'];
$post_remarks = $_POST['remarks'];

// Insert leave data into the 'leaves' table
$query = "INSERT INTO leaves (Leave_Date, Employee_ID, employees_Department, Leave_Type, filed_by, Created_At, Remarks)
          VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "sisssss", $leaveDate, $employeeID, $employeesDepartment, $leaveType, $filedBy, $createdAt, $remarks);

foreach ($leaveDates as $leaveDate) {
    // Assuming you have appropriate validation and sanitization of input values
    $leaveDate = $leaveDate;
    $employeeID = $uID;
    $employeesDepartment = $dept;
    $leaveType = $leaveType;
    $filedBy = $_SESSION['admin_id'];
    $createdAt = date('Y-m-d H:i:s');
    $remarks = $post_remarks;

    // Execute the prepared statement
    $result = mysqli_stmt_execute($stmt);

    if (!$result) {
        // Handle the database error
        $errorMessage = mysqli_error($connection);
        echo "Error: " . $errorMessage;
        exit;
    }

    // Log the leave filing
    if ($result) {
        $action = 'filed';
        $what = '';

        // Determine the specific leave type for the log entry
        if ($leaveType === 'Vacation') {
            $what = 'Vacation Leave for';
        } elseif ($leaveType === 'Sick') {
            $what = 'Sick Leave for';
        } elseif ($leaveType === 'Force') {
            $what = 'Force Leave for';
        } elseif ($leaveType === 'Special') {
            $what = 'Special Leave for';
        } else {
            $what = 'Others Leave for';
        }

        $query_findEmp = "SELECT employees_uid FROM employees WHERE uID='$employeeID'";
        $result_found = mysqli_query($conn, $query_findEmp);

        if ($result_found) {
            $row = mysqli_fetch_assoc($result_found);
            $emp_id = $row['employees_uid'];

            $query_log = "INSERT INTO logs (admin_uID, admin_Name, admin_Action, action_what, action_toWhom) VALUES (?, ?, ?, ?, ?)";
            $stmt_log = $conn->prepare($query_log);
            $stmt_log->bind_param("issss", $_SESSION['admin_uID'], $_SESSION['admin_FirstName'], $action, $what, $emp_id);

            if ($stmt_log->execute()) {
                // Log entry added successfully
            } else {
                // Failed to add log entry
                $response = ['success' => false, 'message' => 'Failed to add log entry.'];
                break;
            }

            $stmt_log->close();
        }
    }
}

// Update the 'employees' table based on the leave type
if ($leaveType === 'Vacation') {
    $updatedVacation = $currentVacation - $leaveDays;
    $query = "UPDATE employees SET Leave_Vacation = ? WHERE uID = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $updatedVacation, $uID);
    // Execute the prepared statement
    $result = mysqli_stmt_execute($stmt);

    if (!$result) {
        // Handle the database error
        $errorMessage = mysqli_error($connection);
        echo "Error: " . $errorMessage;
        exit;
    }
} elseif ($leaveType === 'Sick') {
    $updatedSick = $currentSick - $leaveDays;
    $query = "UPDATE employees SET Leave_Sick = ? WHERE uID = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $updatedSick, $uID);
    // Execute the prepared statement
    $result = mysqli_stmt_execute($stmt);

    if (!$result) {
        // Handle the database error
        $errorMessage = mysqli_error($connection);
        echo "Error: " . $errorMessage;
        exit;
    }
} elseif ($leaveType === 'Force') {
    $updatedForce = $currentForce - $leaveDays;
    $query = "UPDATE employees SET Leave_Force = ? WHERE uID = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $updatedForce, $uID);
    // Execute the prepared statement
    $result = mysqli_stmt_execute($stmt);

    if (!$result) {
        // Handle the database error
        $errorMessage = mysqli_error($connection);
        echo "Error: " . $errorMessage;
        exit;
    }
} elseif ($leaveType === 'Special') {
    $updatedSpecial = $currentSpl - $leaveDays;
    $query = "UPDATE employees SET Leave_Special = ? WHERE uID = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $updatedSpecial, $uID);
    // Execute the prepared statement
    $result = mysqli_stmt_execute($stmt);

    if (!$result) {
        // Handle the database error
        $errorMessage = mysqli_error($connection);
        echo "Error: " . $errorMessage;
        exit;
    }
}

// Send a success response to the AJAX request
echo "Leave data inserted and employees table updated successfully!";
