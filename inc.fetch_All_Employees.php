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
$sql .= " OR employees.employees_sex LIKE '%" . $search_value . "%' ";
$sql .= " OR dept_uid LIKE '%" . $search_value . "%' ";
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
$column = 'employees.employees_uid';
break;
case 1:
$column = 'dept_uid';
break;
case 2:
$column = 'CONCAT(UCASE(employees.employees_FirstName), " ", IF(employees.employees_MiddleName != "", CONCAT(UCASE(SUBSTRING(employees.employees_MiddleName, 1, 1)), "."), ""), " ", UCASE(employees.employees_LastName))';
break;
case 3:
$column = 'employees.Leave_Vacation';
break;
case 4:
$column = 'employees.Leave_Sick';
break;
case 5:
$column = 'employees.Leave_Force';
break;
case 6:
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

    $empName .= ucwords(strtolower($row['employees_LastName']));
    $review_Image = $row['employees_image'];
    $review_Name = $empName;
    $review_Department = $row['dept_uid'];
    $review_Uid = strtoupper($row['employees_uid']);
    $review_Email = $row['employees_Email'];
    $review_Sex =$row['employees_sex'];
    $review_Age =$row['age'];
    $review_AppDate = $row['employees_appointmentDate'];
    $review_Vacation = $row['Leave_Vacation'];
    $review_Sick = $row['Leave_Sick'];
    $review_Force =  $row['Leave_Force'];
    $review_SPL =  $row['Leave_Special'];
    $review_birth =  $row['employees_birthdate'];
    $review_remarks =  $row['employees_remarks'];

    $review_ID = $row['uID'];
    $review_fname = ucwords(strtolower($row['employees_FirstName']));
    $review_mname = ucwords(strtolower($row['employees_MiddleName']));
    $review_lname = ucwords(strtolower($row['employees_LastName']));

    $review_DepartmentUID = $row['employees_Department'];
    $subarray = array();
    $subarray[] = strtoupper($row['employees_uid']);
    $subarray[] = $row['dept_uid']; // Fetching department name from the join
    $subarray[] = $empName;
    $subarray[] = $row['Leave_Vacation'];
    $subarray[] = $row['Leave_Sick'];
    $subarray[] = $row['Leave_Force'];
    $subarray[] = $row['Leave_Special'];
    $subarray[] = $row['employees_remarks'];
    $subarray[] =

    '<button type="button" id="edit" class="btn btn-sm btn-info view-button" data-toggle="modal" data-target="#ViewModal" 
        data-image="'.$review_Image.'" 
        data-name="'.$review_Name.'"
        data-department="'.$review_Department.'"
        data-uid="'.$review_Uid.'"
        data-email="'.$review_Email.'"
        data-sex="'.$review_Sex.'"
        data-age="'.$review_Age.'"
        data-appdate="'.$review_AppDate.'"
        data-vacation="'.$review_Vacation.'"
        data-sick="'.$review_Sick.'"
        data-force="'.$review_Force.'"
        data-spl="'.$review_SPL.'"
        data-emp="'.$review_ID.'"
    ><i class="bi bi-info-circle-fill"></i> View</button>
    
   
    <button type="button" id="edit" class="btn btn-sm btn-secondary edit-button" data-toggle="modal" data-target="#EditDept" 
        data-image="'.$review_Image.'" 
        data-fname="'.$review_fname.'"
        data-mname="'.$review_mname.'"
        data-lname="'.$review_lname.'"
        data-birthdate ="'.$review_birth.'"
        data-department = "'.$review_DepartmentUID.'"
        data-uid="'.$review_ID.'"
        data-empid="'.$review_Uid.'"
        data-email="'.$review_Email.'"
        data-sex="'.$review_Sex.'"
        data-age="'.$review_Age.'"
        data-appdate="'.$review_AppDate.'"
        data-vacation="'.$review_Vacation.'"
        data-sick="'.$review_Sick.'"
        data-force="'.$review_Force.'"
        data-spl="'.$review_SPL.'"
        data-remarks="'.$review_remarks.'"
    ><i class="bi bi-pencil-fill"></i> Edit</button>
    

    <button type="button" id="archive" class="btn btn-sm btn-danger archive-button" data-toggle="modal" data-target="#confirmModal" 
        data-uid="'.$review_ID.'"
        data-empname="'.$empName.'"
    ><i class="bi bi-person-dash-fill"></i> Deact</button>';

    $data[] = $subarray;
}

$output = array(
'data' => $data,
'draw' => intval($_POST['draw']),
'recordsTotal' => $count_all_rows,
'recordsFiltered' => $filtered_rows,
);
echo json_encode($output);
