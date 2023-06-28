<?php
include('includes/dbh.inc.php');
session_start();

$pageLength = $_POST['length'];
$start = $_POST['start'];

// Handle the case when 'department' is not set
$sql = "SELECT * FROM timeoff WHERE employee_ID =" . $_SESSION['employee_uID'];


if (isset($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $sql .= " AND (timeoff.claimed_Time LIKE '%" . $search_value . "%' ";
    $sql .= " OR timeoff.filed_by LIKE '%" . $search_value . "%' ";
    $sql .= " OR timeoff.filed_at LIKE '%" . $search_value . "%') ";
}

if (isset($_POST['order'])) {
    $column = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];

    // Add a switch statement to map the column index to the corresponding column name
    switch ($column) {
        case 0:
            $orderBy = "timeoff.claimed_Time";
            break;
        case 1:
            $orderBy = "timeoff.filed_by";
            break;
        case 2:
            $orderBy = "timeoff.filed_at";
            break;
        default:
            $orderBy = "timeoff.claimed_Time";
            break;
    }

    $sql .= " ORDER BY $orderBy $order";
} else {
    // Default sorting by timeoff.filed_at
    $sql .= " ORDER BY timeoff.filed_at DESC";
}

$data = array();
$query = mysqli_query($conn, $sql);
$count_all_rows = mysqli_num_rows($query);

// Apply search filter
if (isset($_POST['search']['value'])) {
    $filtered_query = mysqli_query($conn, $sql);
    $filtered_rows = mysqli_num_rows($filtered_query);
} else {
    $filtered_rows = $count_all_rows;
}

$sql .= " LIMIT $start, $pageLength";

$query = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($query)) {


    $subarray = array();
    $claimedTimeParts = explode(':', $row['claimed_Time']);
    $hours = intval($claimedTimeParts[0]);
    $minutes = intval($claimedTimeParts[1]);

    $hoursLabel = ($hours <= 1) ? 'hr' : 'hrs';
    $minutesLabel = ($minutes <= 1) ? 'min' : 'mins';

    $subarray[] = $hours . $hoursLabel . ' ' . $minutes . $minutesLabel;


    $subarray[] = $row['filed_by'];
    $subarray[] = date('Y M d g:i A', strtotime($row['filed_at']));




    $data[] = $subarray;
}

$output = array(
    'data' => $data,
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $count_all_rows,
    'recordsFiltered' => $filtered_rows,
);
echo json_encode($output);
