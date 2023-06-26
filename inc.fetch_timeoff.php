<?php
include('includes/dbh.inc.php');

$pageLength = $_POST['length'];
$start = $_POST['start'];
if (isset($_GET['department'])) {
    $selectedDepartment = $_GET['department'];

    $sql = "SELECT employees.*,departments.dept_uid, TIMESTAMPDIFF(YEAR, employees.employees_birthdate, CURDATE()) AS age FROM employees
LEFT JOIN departments ON employees.employees_Department = departments.uid
WHERE employees.is_superadmin = 0 AND employees.is_active = 1";

    if ($selectedDepartment != 0) {
        $sql .= " AND employees.employees_Department = '$selectedDepartment'";

    }
} else {
// Handle the case when 'department' is not set
    $sql = "SELECT employees.*, departments.dept_uid, TIMESTAMPDIFF(YEAR, employees.employees_birthdate, CURDATE()) AS age FROM employees
LEFT JOIN departments ON employees.employees_Department = departments.uid
WHERE employees.is_superadmin = 0 AND employees.is_active = 1";
}

if (isset($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $sql .= " AND (employees.employees_uid LIKE '%" . $search_value . "%' ";
    $sql .= " OR employees.employees_FirstName LIKE '%" . $search_value . "%' ";
    $sql .= " OR employees.employees_MiddleName LIKE '%" . $search_value . "%' ";
    $sql .= " OR employees.employees_LastName LIKE '%" . $search_value . "%' ";
    $sql .= " OR employees.timeoff_Balance LIKE '%" . $search_value . "%' ";
    $sql .= " OR employees.timeoff_Remarks LIKE '%" . $search_value . "%') ";
}

if (isset($_POST['order'])) {
    $column = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];

// Add a switch statement to map the column index to the corresponding column name
    switch ($column) {
        case 0:
            $column = 'employees.employees_uid';
            break;
        case 1:
            $column = 'dept_uid';
            break;
        case 2:
            $column = 'CONCAT(UCASE(employees.employees_FirstName), " ", IF(employees.employees_MiddleName != "", CONCAT(UCASE(SUBSTRING(employees.employees_MiddleName, 1, 1)), "."), ""), " ", UCASE(employees.employees_LastName))';
            break;
        case 3:
            $column = 'employees.timeoff_Balance';
            break;
        case 4:
            $column = 'timeoff_Remarks';
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

    $empName .= ucwords(strtolower($row['employees_LastName']));
    $review_Image = $row['employees_image'];
    $review_Name = $empName;
    $review_Department = $row['dept_uid'];
    $review_Uid = strtoupper($row['employees_uid']);

    $timeoff = $row['timeoff_Balance'];
    $timeoff_remarks = $row['timeoff_Remarks'];
    $review_ID = $row['uID'];

    $review_DepartmentUID = $row['employees_Department'];

    // Extract hours and minutes from the timeoff_Balance
    $hours = date('H', strtotime($timeoff));
    $minutes = date('i', strtotime($timeoff));

    if ($hours < 10) {
        $hours = (int)$hours; // Remove the leading zero
    }

    $hoursLabel = ($hours < 2) ? 'hour' : 'hours';
    $minutesLabel = ($minutes < 2) ? 'minute' : 'minutes';

    $hoursAndMinutes = $hours . ' ' . $hoursLabel . ' ' . $minutes . ' ' . $minutesLabel;

    $subarray = array();
    $subarray[] = strtoupper($row['employees_uid']);
    $subarray[] = $row['dept_uid']; // Fetching department name from the join
    $subarray[] = $empName;
    $subarray[] = $hoursAndMinutes; // Add the concatenated hours and minutes
    $subarray[] = $timeoff_remarks;
    $subarray[] =



        '<button type="button" id="edit" class="btn btn-sm btn-secondary remarks-button" data-toggle="modal" data-target="#RemarksModal" 
        data-image="'.$review_Image.'" 
        data-uid="'.$review_ID.'"
        data-empid="'.$review_Uid.'"
        data-time="'.$timeoff.'"
         data-empname="'.$empName.'"
         data-dept="'.$review_Department.'"
        data-remarks="'.$timeoff_remarks.'"
    ><i class="bi bi-pencil-fill"></i> Edit Remarks</button>
    
        <button type="button" id="add" class="btn btn-sm add-credit" data-toggle="modal" data-target="#AddTimeOffModal"  style="margin-top: 5px"
        data-image ="'.$review_Image.'"
        data-uid="'.$review_ID.'"
        data-dept="'.$review_Department.'"
        data-empname="'.$empName.'"
        data-credits="'.$timeoff.'"
    ><span class="material-symbols-rounded">acute</span> Add Time-Off</button>
    
    <button type="button" id="claim" class="btn btn-sm  btn-primary claim-button" data-toggle="modal" data-target="#ClaimTimeOffModal"  style="margin-top: 5px"
        data-image ="'.$review_Image.'"
        data-uid="'.$review_ID.'"
        data-dept="'.$review_Department.'"
        data-empname="'.$empName.'"
        data-credits="'.$timeoff.'"
    ><i class="bi bi-hourglass-split"></i> Claim Time-Off</button>
    
    ';

    $data[] = $subarray;
}

$output = array(
    'data' => $data,
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $count_all_rows,
    'recordsFiltered' => $filtered_rows,
);
echo json_encode($output);
