<?php
include('includes/dbh.inc.php');

$pageLength = $_POST['length'];
$start = $_POST['start'];
if (isset($_GET['department'])) {
    $selectedDepartment = $_GET['department'];

    $sql = "SELECT employees.*, departments.dept_uid, TIMESTAMPDIFF(YEAR, employees.employees_birthdate, CURDATE()) AS age FROM employees
            LEFT JOIN departments ON employees.employees_Department = departments.uid
            WHERE employees.is_superadmin = 0";

    if ($selectedDepartment != 0) {
        $sql .= " AND employees.employees_Department = '$selectedDepartment'";
    }
} else {
    // Handle the case when 'department' is not set
    $sql = "SELECT employees.*, departments.dept_uid, TIMESTAMPDIFF(YEAR, employees.employees_birthdate, CURDATE()) AS age FROM employees
            LEFT JOIN departments ON employees.employees_Department = departments.uid
            WHERE employees.is_superadmin = 0";
}

if (isset($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $sql .= " AND (employees_uid LIKE '%" . $search_value . "%' ";
    $sql .= " OR employees_FirstName LIKE '%" . $search_value . "%' ";
    $sql .= " OR employees_MiddleName LIKE '%" . $search_value . "%' ";
    $sql .= " OR employees_LastName LIKE '%" . $search_value . "%' ";
    $sql .= " OR employees_sex LIKE '%" . $search_value . "%' ";
    $sql .= " OR employees_Department LIKE '%" . $search_value . "%' ";
    $sql .= " OR Leave_Vacation LIKE '%" . $search_value . "%' ";
    $sql .= " OR Leave_Sick LIKE '%" . $search_value . "%' ";
    $sql .= " OR Leave_Force LIKE '%" . $search_value . "%' ";
    $sql .= " OR Leave_Special LIKE '%" . $search_value . "%') ";
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
            $column = 'employees_Department';
            break;
        case 2:
            $column = 'CONCAT(UCASE(employees_FirstName), " ", IF(employees_MiddleName != "", CONCAT(UCASE(SUBSTRING(employees_MiddleName, 1, 1)), "."), ""), " ", UCASE(employees_LastName))';
            break;
        case 3:
            $column = 'Leave_Vacation';
            break;
        case 4:
            $column = 'Leave_Sick';
            break;
        case 5:
            $column = 'Leave_Force';
            break;
        case 6:
            $column = 'Leave_Special';
            break;

        // Add cases for other columns as needed

        // Use employees_uid as the default column
        default:
            $column = 'employees_uid';
            break;
    }

    $sql .= " ORDER BY " . $column . " " . $order;
} else {
    $sql .= " ORDER BY employees_Department ASC";
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
    $subarray[] = strtoupper($row['employees_uid']);
    $subarray[] = $row['dept_uid']; // Fetching department name from the join
    $subarray[] = ucwords(strtolower($row['employees_FirstName'])) . ' ' . strtoupper(substr($row['employees_MiddleName'], 0, 1)) . '. ' . ucwords(strtolower($row['employees_LastName']));
    $empName = ucwords(strtolower($row['employees_FirstName'])) . ' ' . strtoupper(substr($row['employees_MiddleName'], 0, 1)) . '. ' . ucwords(strtolower($row['employees_LastName']));
    $subarray[] = $row['Leave_Vacation'];
    $subarray[] = $row['Leave_Sick'];
    $subarray[] = $row['Leave_Force'];
    $subarray[] = $row['Leave_Special'];
    $subarray[] = '<button type="button" id="edit" class="btn btn-sm btn-info edit-button" data-toggle="modal" data-target="#EditDept" data-deptid="'.$row['uID'].'"><i class="bi bi-info-circle-fill"></i> View</button>
    <button type="button" id="edit" class="btn btn-sm btn-secondary edit-button" data-toggle="modal" data-target="#EditDept" data-deptid="'.$row['uID'].'"><i class="bi bi-pencil-fill"></i> Edit</button>
    <button type="button" id="removeBtn_'.$row['employees_uid'].'" class="btn btn-sm btn-danger remove-admin-button" data-toggle="modal" data-target="#confirmModal" data-employeeid="'.$row['employees_uid'].'" data-empname="'.$empName.'"><i class="bi bi-person-dash-fill"></i> Remove</button>';

    $data[] = $subarray;
}

$output = array(
    'data' => $data,
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $count_all_rows,
    'recordsFiltered' => $filtered_rows,
);
echo json_encode($output);






