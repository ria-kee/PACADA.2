<?php
include('includes/dbh.inc.php');
session_start();

$pageLength = $_POST['length'];
$start = $_POST['start'];

// Handle the case when 'department' is not set
$sql = "SELECT * FROM leaves WHERE Employee_ID =" . $_SESSION['employee_uID'];


if (isset($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $sql .= " AND (leaves.Leave_Date LIKE '%" . $search_value . "%' ";
    $sql .= " OR leaves.Leave_Type LIKE '%" . $search_value . "%' ";
    $sql .= " OR leaves.filed_by LIKE '%" . $search_value . "%' ";
    $sql .= " OR leaves.Created_At LIKE '%" . $search_value . "%') ";
}

if (isset($_POST['order'])) {
    $column = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];

    // Add a switch statement to map the column index to the corresponding column name
    switch ($column) {
        case 0:
            $orderBy = "leaves.Leave_Date";
            break;
        case 1:
            $orderBy = "leaves.Leave_Type";
            break;
        case 2:
            $orderBy = "leaves.filed_by";
            break;
        case 3:
            $orderBy = "leaves.Created_At";
            break;
        default:
            $orderBy = "leaves.Leave_Date";
            break;
    }

    $sql .= " ORDER BY $orderBy $order";
} else {
    // Default sorting by Leave_Date
    $sql .= " ORDER BY leaves.Leave_Date DESC";
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
    $subarray[] = date('Y M d', strtotime($row['Leave_Date']));

    $subarray[] = $row['Leave_Type'];
    $subarray[] = $row['filed_by'];
    $subarray[] = date('Y M d g:i A', strtotime($row['Created_At']));




    $data[] = $subarray;
}

$output = array(
    'data' => $data,
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $count_all_rows,
    'recordsFiltered' => $filtered_rows,
);
echo json_encode($output);
