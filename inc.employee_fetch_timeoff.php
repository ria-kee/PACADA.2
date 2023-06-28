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

    $timeoffBalance = $row['timeoff_Balance'];
    $timeComponents = explode(':', $timeoffBalance);
    $hours = (int)$timeComponents[0];
    $minutes = (int)$timeComponents[1];

    $formattedTimeoffBalance = '';
    if ($hours > 0) {
        $formattedTimeoffBalance .= $hours . ($hours > 1 ? 'hrs ' : 'hr ');
    }
    if ($minutes > 0) {
        $formattedTimeoffBalance .= $minutes . ($minutes > 1 ? 'mins' : 'min');
    }

    $subarray = array();
    $subarray[] =  $empName;
    $subarray[] = $formattedTimeoffBalance;
    $data[] = $subarray;
}


$output = array(
    'data' => $data,
    'draw' => intval($_POST['draw']),
);
echo json_encode($output);
