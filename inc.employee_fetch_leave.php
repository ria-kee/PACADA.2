<?php
include('includes/dbh.inc.php');
session_start();

// Handle the case when 'department' is not set
$sql = "SELECT * FROM employees WHERE uID =" . $_SESSION['employee_uID'];
$query = mysqli_query($conn, $sql);
$data = array();

while ($row = mysqli_fetch_assoc($query)) {
    $empName = ucwords(strtolower($row['employees_FirstName'])) . ' ';
    if (!empty($row['employees_MiddleName'])) {
        $empName .= strtoupper(substr($row['employees_MiddleName'], 0, 1)) . '. ';
    }
    $empName .= ucwords(strtolower($row['employees_LastName']));


    $subarray = array();
    $subarray[] =  $empName;
    $subarray[] = $row['Leave_Vacation'];
    $subarray[] = $row['Leave_Sick'];
    $subarray[] = $row['Leave_Special'];
    $subarray[] = $row['Leave_Force'];


    $data[] = $subarray;
}

$output = array(
    'data' => $data,
    'draw' => intval($_POST['draw']),
);
echo json_encode($output);
