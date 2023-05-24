<?php
include('includes/dbh.inc.php');


$sql = "SELECT *, TIMESTAMPDIFF(YEAR, employees_birthdate, CURDATE()) AS age FROM employees WHERE is_admin = 1";

if (isset($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $sql .= " AND (employees_uid LIKE '%" . $search_value . "%' ";
    $sql .= " OR employees_FirstName LIKE '%" . $search_value . "%' ";
    $sql .= " OR employees_MiddleName LIKE '%" . $search_value . "%' ";
    $sql .= " OR employees_LastName LIKE '%" . $search_value . "%' ";
    $sql .= " OR employees_sex LIKE '%" . $search_value . "%' ";
    $sql .= " OR employees_birthdate LIKE '%" . $search_value . "%' ";
    $sql .= " OR employees_Department LIKE '%" . $search_value . "%' ";
    $sql .= " OR employees_Email LIKE '%" . $search_value . "%' ";
    $sql .= " OR employees_Password LIKE '%" . $search_value . "%') ";
}

if (isset($_POST['order'])) {
    $column = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];

    // Add a switch statement to map the column index to the corresponding column name
    switch ($column) {
        case 0:
            $column = 'employees_uid';
            break;
        case 1:
            $column = 'employees_FirstName';
            break;
        case 2:
            $column = 'employees_MiddleName';
            break;
        case 3:
            $column = 'employees_LastName';
            break;
        case 4:
            $column = 'employees_sex';
            break;
        case 5:
            $column = 'age';
            break;
        case 6:
            $column = 'employees_Department';
            break;
        // Add cases for other columns as needed

        // Use employees_uid as the default column
        default:
            $column = 'employees_uid';
            break;
    }

    $sql .= " ORDER BY " . $column . " " . $order;
} else {
    $sql .= " ORDER BY employees_uid ASC";
}

$data = array();
$query = mysqli_query($conn, $sql);
$count_all_rows = mysqli_num_rows($query);

// Apply search filter if there is any
if (isset($_POST['search']['value'])) {
    $filtered_query = mysqli_query($conn, $sql);
    $filtered_rows = mysqli_num_rows($filtered_query);
} else {
    $filtered_rows = $count_all_rows;
}

if ($_POST['length'] != -1) {
    $start = $_POST['start'];
    $length = $_POST['length'];
    $sql .= " LIMIT " . $start . ", " . $length;
}

$query = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($query)) {
    $subarray = array();
    $subarray[] = strtoupper($row['employees_uid']);
    $subarray[] = ucwords(strtolower($row['employees_FirstName']));
    $subarray[] = ucwords(strtolower($row['employees_MiddleName']));
    $subarray[] = ucwords(strtolower($row['employees_LastName']));
    $subarray[] = strtoupper($row['employees_sex']);
    $subarray[] = $row['age'];
    $subarray[] = $row['employees_Department'];
    $subarray[] = '<a href="javascript:void();" class="btn btn-sm btn-danger" data-employee-id="'.$row['employees_uid'].'"><i class="bi bi-person-dash-fill"></i> Remove</a>';
    $data[] = $subarray;
}

$output = array(
    'data' => $data,
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $count_all_rows,
    'recordsFiltered' => $filtered_rows,
);

echo json_encode($output);
