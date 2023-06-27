<?php
include('includes/dbh.inc.php');

$pageLength = $_POST['length'];
$start = $_POST['start'];

// Retrieve the decrypted employee ID from the AJAX request
$decryptedEmpID = $_POST['employeeID'];



    $sql = "SELECT * FROM leaves WHERE Employee_ID = $decryptedEmpID";

if (isset($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $sql .= " AND (leaves.Leave_Date LIKE '%" . $search_value . "%' ";
    $sql .= " OR leaves.Leave_Type LIKE '%" . $search_value . "%' ";
    $sql .= " OR leaves.filed_by LIKE '%" . $search_value . "%' ";
    $sql .= " OR leaves.Created_At LIKE '%" . $search_value . "%' ";
    $sql .= " OR leaves.Remarks LIKE '%" . $search_value . "%') ";
}

if (isset($_POST['order'])) {
    $column = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];

// Add a switch statement to map the column index to the corresponding column name
    switch ($column) {
        case 0:
            $column = 'leaves.Leave_Date';
            break;
        case 1:
            $column = 'leaves.Leave_Type';
            break;
        case 2:
            $column = 'leaves.filed_by';
            break;
        case 3:
            $column = 'leaves.Created_At';
            break;
        case 4:
            $column = 'leaves.Remarks';
            break;

//  default column
        default:
            $column = 'leaves.Leave_Date';
            break;
    }

    $sql .= " ORDER BY " . $column . " " . $order;
} else {
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
    $subarray[] =($row['Leave_Date']);
    $subarray[] = $row['Leave_Type'];
    $subarray[] = $row['filed_by'];
    $subarray[] = $row['Created_At'];
    $subarray[] = $row['Remarks'];
    $data[] = $subarray;
}

$output = array(
    'data' => $data,
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $count_all_rows,
    'recordsFiltered' => $filtered_rows,
);
echo json_encode($output);
