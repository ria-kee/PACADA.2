<?php
include('includes/dbh.inc.php');

$pageLength = $_POST['length'];
$start = $_POST['start'];



$sql = "SELECT logs.*, employees.employees_uid
        FROM logs
        INNER JOIN employees ON logs.admin_uID = employees.uID";

if (isset($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $sql .= " WHERE (employees.employees_uid LIKE '%" . $search_value . "%' ";
    $sql .= " OR logs.admin_Name LIKE '%" . $search_value . "%' ";
    $sql .= " OR logs.admin_Action LIKE '%" . $search_value . "%' ";
    $sql .= " OR logs.action_what LIKE '%" . $search_value . "%' ";
    $sql .= " OR logs.action_toWhom LIKE '%" . $search_value . "%' ";
    $sql .= " OR logs.createdAt LIKE '%" . $search_value . "%') ";
}

if (isset($_POST['order'])) {
    $column = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];

    switch ($column) {
        case 0:
            $column = 'logs.createdAt';
            break;
        case 1:
            $column = 'employees.employees_uid';
            break;
        case 2:
            $column = 'logs.admin_Name';
            break;
        case 3:
            $column = 'logs.admin_Action';
            break;
        case 4:
            $column = 'logs.action_what';
            break;
        case 5:
            $column = 'logs.action_toWhom';
            break;
        default:
            $column = 'logs.createdAt';
            break;
    }

    $sql .= " ORDER BY " . $column . " " . $order;
} else {
    $sql .= " ORDER BY logs.createdAt ASC";
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
    $subarray[] = date('M d, Y h:i A', strtotime($row['createdAt']));

    $subarray[] = strtoupper($row['employees_uid']); // Fetching emp ID from the join
    $subarray[] = $row['admin_Name'];
    $subarray[] = $row['admin_Action'];
    $subarray[] = $row['action_what'];
    $subarray[] = $row['action_toWhom'];
    $data[] = $subarray;
}

$output = array(
    'data' => $data,
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $count_all_rows,
    'recordsFiltered' => $filtered_rows,
);

echo json_encode($output);
