<?php

include('includes/dbh.inc.php');

if (isset($_POST['uID']) && isset($_POST['current']) && isset($_POST['claim']) && isset($_POST['remarks'])) {
    $uID = $_POST['uID'];
    $current = $_POST['current'];
    $claim = $_POST['claim'];
    $remarks = $_POST['remarks'];

    // Prepare the update statement
    $sql_update = "UPDATE employees SET timeoff_Balance = SUBTIME(timeoff_Balance, ?), timeoff_Remarks = ? WHERE uID = ?";
    $stmt = mysqli_prepare($conn, $sql_update);

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, "sss", $claim, $remarks, $uID);


    // Execute the statement
    $result_update = mysqli_stmt_execute($stmt);


    if ($result_update) {

        session_start();
        $claimTime = explode(':', $claim);
        $hours = (int)$claimTime[0];
        $minutes = (int)$claimTime[1];

        $action = 'claimed ';

        if ($hours === 0 && $minutes === 0) {
            $action .= '0 hr 0 min';
        } else {
            $action .= sprintf("%d hr %d min", $hours, $minutes);
        }

        $what = 'time-off credits for';

        $query_findDept = "SELECT employees_uid, employees_Department FROM employees WHERE uID='$uID'";
        $result_found = mysqli_query($conn, $query_findDept);

        if ($result_found) {
            $row = mysqli_fetch_assoc($result_found);
            $employee = $row['employees_uid'];
            $dept = $row['employees_Department'];
        }

        $query_log = "INSERT INTO logs (admin_uID, admin_Name, admin_Action, action_what, action_toWhom) VALUES (?, ?, ?, ?, ?)";
        $stmt_log = $conn->prepare($query_log);
        $stmt_log->bind_param("issss", $_SESSION['admin_uID'], $_SESSION['admin_FirstName'], $action, $what, $employee);

        if ($stmt_log->execute()) {
            // Department and log entry added successfully
            $response = ['success' => true];
        } else {
            // Failed to add log entry
            $response = ['success' => false];
        }

        $stmt_log->close();


        $query_claim="INSERT INTO timeoff ( claimed_Time, employee_ID, employee_department,filedby_ID, filed_by,remarks) VALUES ( ?, ?, ?, ?, ?,?)";
        $stmt_claim = $conn->prepare($query_claim);
        $stmt_claim->bind_param("siiiss", $claim, $uID,$dept,$_SESSION['admin_uID'],  $_SESSION['admin_id'], $remarks );

        if ($stmt_claim->execute()) {
            // Department and log entry added successfully
            $response = ['success' => true];
        } else {
            // Failed to add log entry
            $response = ['success' => false];
        }


        // Return a success message
        echo "Time-Off Remarks updated successfully!";
    } else {
        // Return an error message
        http_response_code(500); // Set the HTTP response code to indicate an error
        echo "Failed to update Time-Off Remarks.";
    }

} else {
    // Return an error message if the request method is not POST
    echo "Invalid request!";
}
