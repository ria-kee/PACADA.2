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

    $claimedTimeParts = explode(':', $row['timeoff_Balance']);
    $hours = intval($claimedTimeParts[0]);
    $minutes = intval($claimedTimeParts[1]);

    $hoursLabel = ($hours <= 1) ? 'hr' : 'hrs';
    $minutesLabel = ($minutes <= 1) ? 'min' : 'mins';




    $subarray = array();
    $subarray[] =  $empName;
    $subarray[] = $hours . $hoursLabel . ' ' . $minutes . $minutesLabel;
    $data[] = $subarray;
}


$output = array(
    'data' => $data,
    'draw' => intval($_POST['draw']),
);
echo json_encode($output);
