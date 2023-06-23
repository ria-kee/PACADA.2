<?php
include('includes/dbh.inc.php');

$pageLength = $_POST['length'];
$start = $_POST['start'];
if (isset($_GET['department'])) {
    $selectedDepartment = $_GET['department'];

    $sql = "SELECT leaves.*, employees.employees_FirstName, employees.employees_MiddleName, employees.employees_LastName, departments.dept_uid 
        FROM leaves 
        LEFT JOIN employees ON leaves.Employee_ID = employees.uID 
        LEFT JOIN departments ON employees.employees_Department = departments.uID 
        WHERE  employees.is_superadmin = 0 AND employees.is_active = 1";


    if ($selectedDepartment != 0) {
        $sql .= " AND leaves.employees_Department = '$selectedDepartment'";

    }
} else {
// Handle the case when 'department' is not set
    $sql = "SELECT leaves.*, employees.employees_FirstName, employees.employees_MiddleName, employees.employees_LastName, departments.dept_uid 
        FROM leaves 
        LEFT JOIN employees ON leaves.Employee_ID = employees.uID 
        LEFT JOIN departments ON employees.employees_Department = departments.uID 
        WHERE employees.is_superadmin = 0 AND employees.is_active = 1";
}

if (isset($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $sql .= " AND (leaves.Leave_Date LIKE '%" . $search_value . "%' ";
    $sql .= " OR CONCAT(UCASE(employees.employees_FirstName), ' ', 
                         IF(employees.employees_MiddleName != '', CONCAT(UCASE(SUBSTRING(employees.employees_MiddleName, 1, 1)), '.'), ''), ' ', 
                         UCASE(employees.employees_LastName)) LIKE '%" . $search_value . "%' ";
    $sql .= " OR departments.dept_uid LIKE '%" . $search_value . "%' ";
    $sql .= " OR leaves.Leave_Type LIKE '%" . $search_value . "%' ";
    $sql .= " OR leaves.Created_At LIKE '%" . $search_value . "%' ";
    $sql .= " OR leaves.Remarks LIKE '%" . $search_value . "%') ";
}

// Retrieve the date range values from the AJAX request
$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];

// Modify the SQL query to include the date range filter if the inputs are not empty
if (!empty($fromDate) && !empty($toDate)) {
    $sql .= " AND leaves.Leave_Date >= '$fromDate' AND leaves.Leave_Date <= '$toDate'";
} elseif (!empty($fromDate)) {
    $sql .= " AND leaves.Leave_Date >= '$fromDate'";
} elseif (!empty($toDate)) {
    $sql .= " AND leaves.Leave_Date <= '$toDate'";
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
            $orderBy = "CONCAT(UCASE(employees.employees_FirstName), ' ', 
                              IF(employees.employees_MiddleName != '', CONCAT(UCASE(SUBSTRING(employees.employees_MiddleName, 1, 1)), '.'), ''), ' ', 
                              UCASE(employees.employees_LastName))";
            break;
        case 2:
            $orderBy = "departments.dept_uid";
            break;
        case 3:
            $orderBy = "leaves.Leave_Type";
            break;
        case 4:
            $orderBy = "leaves.Created_At";
            break;
        case 5:
            $orderBy = "leaves.Remarks";
            break;
        default:
            $orderBy = "leaves.Leave_Date";
            break;
    }

    // Add the order by clause to the SQL query
    $sql .= " ORDER BY $orderBy $order";
}else {
    // Default sorting by Leave_Date
    $sql .= " ORDER BY leaves.Leave_Date";
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
    $empName .= ucwords(strtolower($row['employees_LastName']));

    $subarray = array();
    $subarray[] = $row['Leave_Date'];
    $subarray[] = $empName;
    $subarray[] = $row['dept_uid']; // Fetching department name from the join
    $subarray[] = $row['Leave_Type'];
    $subarray[] = $row['Created_At'];
    $subarray[] = $row['filed_by'];
    $subarray[] = $row['Remarks'];
    $subarray[] =

        '<button type="button" id="archive" class="btn btn-sm btn-danger cancel-button" data-toggle="modal" data-target="#confirmModal" 
        data-uid="'.$row['uID'].'"
        data-empname="'.$empName.'"
    ><span class="material-symbols-rounded" style="font-size: 18px">event_busy</span> Cancel</button>';



    $data[] = $subarray;
}

$output = array(
    'data' => $data,
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $count_all_rows,
    'recordsFiltered' => $filtered_rows,
);
echo json_encode($output);
