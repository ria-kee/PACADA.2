<?php
include('includes/dbh.inc.php');

$sql = "SELECT *, TIMESTAMPDIFF(YEAR, adminsBirthdate, CURDATE()) AS age FROM admins";

if (isset($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $sql .= " WHERE adminsUid LIKE '%" . $search_value . "%' ";
    $sql .= " OR adminsFirstName LIKE '%" . $search_value . "%' ";
    $sql .= " OR adminsMiddleName LIKE '%" . $search_value . "%' ";
    $sql .= " OR adminsLastName LIKE '%" . $search_value . "%' ";
    $sql .= " OR adminsSex LIKE '%" . $search_value . "%' ";
    $sql .= " OR adminsBirthdate LIKE '%" . $search_value . "%' ";
    $sql .= " OR adminsDepartment LIKE '%" . $search_value . "%' ";
    $sql .= " OR adminsEmail LIKE '%" . $search_value . "%' ";
    $sql .= " OR adminsPassword LIKE '%" . $search_value . "%' ";
}

if (isset($_POST['order'])) {
    $column = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];

    // Add a switch statement to map the column index to the corresponding column name
    switch ($column) {
        case 0:
            $column = 'adminsUid';
            break;
        case 1:
            $column = 'adminsFirstName';
            break;
        case 2:
            $column = 'adminsMiddleName';
            break;
        case 3:
            $column = 'adminsLastName';
            break;
        case 4:
            $column = 'adminsSex';
            break;
        case 5:
            $column = 'age';
            break;
        case 6:
            $column = 'adminsDepartment';
            break;
        // Add cases for other columns as needed

        // Use adminsUid as the default column
        default:
            $column = 'adminsUid';
            break;
    }

    $sql .= " ORDER BY " . $column . " " . $order;
} else {
    $sql .= " ORDER BY adminsUid ASC";
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

$data = array();
$query = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($query)) {
    $subarray = array();
    $subarray[] = strtoupper($row['adminsUid']);
    $subarray[] = ucwords(strtolower($row['adminsFirstName']));
    $subarray[] = ucwords(strtolower($row['adminsMiddleName']));
    $subarray[] = ucwords(strtolower($row['adminsLastName']));
    $subarray[] = $row['adminsSex'];
    $subarray[] = $row['age'];
    $subarray[] = $row['adminsDepartment'];
    $subarray[] = '<a href="javascript:void();" class="btn btn-sm btn-info">Edit</a> 
                   <a href="javascript:void();" class="btn btn-sm btn-danger">Delete</a>';
    $data[] = $subarray;
}

$output = array(
    'data' => $data,
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $count_all_rows,
    'recordsFiltered' => $filtered_rows,
);

echo json_encode($output);

