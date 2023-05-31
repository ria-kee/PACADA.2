<?php
// Database connection file
include('includes/dbh.inc.php');

$pageLength = $_POST['length'];
$start = $_POST['start'];

$sql = "SELECT * FROM departments";

if (isset($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $sql .= " WHERE (dept_uid LIKE '%" . $search_value . "%' ";
    $sql .= " OR dept_Description LIKE '%" . $search_value . "%') ";
}

if (isset($_POST['order'])) {
    $column = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];

    // Add a switch statement to map the column index to the corresponding column name
    switch ($column) {
        case 0:
            $column = 'dept_uid';
            break;
        case 1:
            $column = 'dept_Description';
            break;
        // Use dept_uid as the default column
        default:
            $column = 'dept_uid';
            break;
    }

    $sql .= " ORDER BY " . $column . " " . $order;
} else {
    $sql .= " ORDER BY dept_uid ASC";
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
    // Create a temporary array to store each row's data
    $subarray = array();
    $subarray[] = $row['dept_uid'];
    $subarray[] = $row['dept_Description'];
    $subarray[] = '<button type="button" id="edit" class="btn btn-sm btn-secondary edit-button" data-toggle="modal" data-target="#EditDept" data-deptid="'.$row['uID'].'"><i class="bi bi-pencil-fill"></i> Edit</button>
                   <button type="button" id="remove" class="btn btn-sm btn-danger remove-button" data-toggle="modal" data-target="#RemoveDept" data-deptid="'.$row['uID'].'" data-acronyms="'.$row['dept_uid'].'"  data-department="'.$row['dept_Description'].'"><i class="bi bi-person-dash-fill"></i> Remove</button>';

    $data[] = $subarray;
}

$output = array(
    'data' => $data,
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $count_all_rows,
    'recordsFiltered' => $filtered_rows,
);

echo json_encode($output);
