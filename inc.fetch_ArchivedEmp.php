<?php
include('includes/dbh.inc.php');

$pageLength = $_POST['length'];
$start = $_POST['start'];

$sql = "SELECT employees.*, departments.dept_uid, TIMESTAMPDIFF(YEAR, employees.employees_birthdate, CURDATE()) AS age FROM employees
LEFT JOIN departments ON employees.employees_Department = departments.uid
WHERE employees.is_superadmin = 0 AND employees.is_active = 0";


if (isset($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $sql .= " AND (employees.employees_uid LIKE '%" . $search_value . "%' ";
    $sql .= " OR employees.employees_FirstName LIKE '%" . $search_value . "%' ";
    $sql .= " OR employees.employees_MiddleName LIKE '%" . $search_value . "%' ";
    $sql .= " OR employees.employees_LastName LIKE '%" . $search_value . "%' ";
    $sql .= " OR employees.employees_sex LIKE '%" . $search_value . "%' ";
    $sql .= " OR employees.employees_Department LIKE '%" . $search_value . "%' ";
    $sql .= " OR employees.Leave_Vacation LIKE '%" . $search_value . "%' ";
    $sql .= " OR employees.Leave_Sick LIKE '%" . $search_value . "%' ";
    $sql .= " OR employees.Leave_Force LIKE '%" . $search_value . "%' ";
    $sql .= " OR employees.Leave_Special LIKE '%" . $search_value . "%') ";
}

if (isset($_POST['order'])) {
    $column = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];

// Add a switch statement to map the column index to the corresponding column name
    switch ($column) {
        case 0:
            $column = '';
            break;
        case 1:
            $column = 'employees.employees_uid';
            break;
        case 2:
            $column = 'employees.employees_Department';
            break;
        case 3:
            $column = 'CONCAT(UCASE(employees.employees_FirstName), " ", IF(employees.employees_MiddleName != "", CONCAT(UCASE(SUBSTRING(employees.employees_MiddleName, 1, 1)), "."), ""), " ", UCASE(employees.employees_LastName))';
            break;
        case 4:
            $column = 'employees.Leave_Vacation';
            break;
        case 5:
            $column = 'employees.Leave_Sick';
            break;
        case 6:
            $column = 'employees.Leave_Force';
            break;
        case 7:
            $column = 'employees.Leave_Special';
            break;

// Use employees.employees_uid as the default column
        default:
            $column = 'employees.employees_uid';
            break;
    }

    $sql .= " ORDER BY " . $column . " " . $order;
} else {
    $sql .= " ORDER BY employees.employees_Department ASC";
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

    $empName = ucwords(strtolower($row['employees_FirstName'])) . ' ';

    if (!empty($row['employees_MiddleName'])) {
        $empName .= strtoupper(substr($row['employees_MiddleName'], 0, 1)) . '. ';
    }

    $empName .= ucwords(strtolower($row['employees_LastName']));    $review_Image = $row['employees_image'];




    $subarray = array();
    $subarray[] = '<input class="form-check-input" type="checkbox" value="'.$row['uID'].'" data-id="'.$row['uID'].'" >';





    $subarray[] = strtoupper($row['employees_uid']);
    $subarray[] = $row['dept_uid']; // Fetching department name from the join
    $subarray[] = $empName;
    $subarray[] = $row['Leave_Vacation'];
    $subarray[] = $row['Leave_Sick'];
    $subarray[] = $row['Leave_Force'];
    $subarray[] = $row['Leave_Special'];
    $subarray[] = $row['employees_remarks'];
    $subarray[] = '
    <button type="button" id="activate" class="btn btn-sm btn-success activate-button" data-toggle="modal" data-target="#ActivateEmp" data-act_id="'.$row['uID'].'"  data-id="'.$row['uID'].'" data-empid="'.$row['employees_uid'].'" data-empname="'.$empName.'"><i class="bi bi-person-check-fill"></i> Activate</button>
    <button type="button" id="remove"  class="btn btn-sm btn-danger remove-button" data-toggle="modal" data-target="#DeleteEmp" data-id="'.$row['uID'].'" data-empid="'.$row['employees_uid'].'" data-empname="'.$empName.'"><i class="bi bi-person-x-fill"></i> Remove</button>';

    $data[] = $subarray;
}

$output = array(
    'data' => $data,
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $count_all_rows,
    'recordsFiltered' => $filtered_rows,
);

echo json_encode($output);
