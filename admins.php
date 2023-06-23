<?php
session_start();
$allowedPages = ['dashboard.php', 'departments.php', 'employees.php',
    'leave.php', 'timeOff.php', 'profile.php',
    'archived_departments.php', 'credits.php', 'archived_employees.php', 'view_logs.php']; // List of allowed pages

$currentFile = basename($_SERVER['PHP_SELF']); // Get the name of the current PHP file

// Check if the user is not logged in and the current page is not in the allowed pages list
if (!isset($_SESSION['admin_uID']) && !in_array($currentFile, $allowedPages)) {
    // Redirect the user to the login page or show access denied message
    header('Location: error.401.php');
    exit();
}
?>

<!-- jQuery CDN Library -->
<script src="js/bootstrap/jquery-3.6.0.min.js"></script>
<!-- BOOTSTRAP LIBRARY -->
<link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<script src="js/bootstrap/bootstrap.bundle.min.js"></script>
<!-- DATATABLE LIBRARY -->
<link rel="stylesheet" href="css/bootstrap/datatables.min.css">
<script src="js/bootstrap/datatables.min.js"></script>
<!-- CUSTOM CSS -->
<link rel="stylesheet" href="css/style_admins.css">

<!--EXPORT-->
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>


<?php include_once "header/active_admins.php"; ?>
<?php include('includes/dbh.inc.php'); ?>

<div class="whole-container">
    <div id="alertContainer" class="position-fixed top-0 end-0 p-3">
        <!-- Success Alert -->
        <div class="alert alert-success alert-dismissible d-none" role="alert" id="successAlert">
            <i class="bi-check-circle-fill me-2"></i>
            <strong>Success!</strong>
        </div>

        <!-- Error Alert -->
        <div class="alert alert-danger alert-dismissible d-none" role="alert" id="errorAlert">
            <i class="bi-exclamation-octagon-fill me-2"></i>
            <strong>Error!</strong>
        </div>
    </div>

    <div class="body-container">
        <div class="grid-container body-item">
            <div class="grid-item">
                <h3>What are you looking for?</h3>
            </div>
            <div class="grid-item"></div>
            <div class="grid-item">
                <div class="search">
                    <span class="material-symbols-rounded">search</span>
                    <input type="text" class="searchField" placeholder="Search for name, id, or etc.">
                </div>
            </div>
            <div class="grid-item"></div>
        </div>
        <div class="button-container body-item">
            <div class="grid-item actions">
                <span class="material-symbols-rounded">sprint</span>
                <h3>Quick Actions</h3>
            </div>
            <div class="grid-tem"></div>
            <div class="grid-tem"></div>
            <div class="grid-tem actions">
                <span class="material-symbols-rounded">download</span>
                <h3>Export Table</h3>
            </div>
            <div class="grid-item button1" data-bs-toggle="modal" data-bs-target="#AddAdmin">
                <span class="material-symbols-rounded">add</span>
                <button>Add Admin</button>
            </div>
            <a href="view_logs.php">
            <div class="grid-item button2">
                <span class="material-symbols-rounded">visibility</span>
                <button>View Logs</button>
            </div>
            </a>
            <div class="vl"></div>
            <div class="grid-item">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        File Type
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item d-flex justify-content-between align-items-center" type="button" id="excelExport">
                                <span>Excel</span>
                                <i class="bi bi-filetype-xlsx"></i>
                            </a>
                        </li>
                        <li><a class="dropdown-item d-flex justify-content-between align-items-center" type="button" id="pdfExport">
                                <span>PDF</span>
                                <i class="bi bi-filetype-pdf"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="tablead">
        <div class="table-top">
            <h3><b>ADMINISTRATORS</b></h3>
        </div>
        <table id="adminTable" class="table table-striped" style="width:100%">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Department</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Sex</th>
                <th>Age</th>
                <th data-orderable="false">Options</th>
            </tr>
            </thead>
            <tbody class="table-striped">
            </tbody>
        </table>
    </div>
</div>

<!-- ADD ADMIN MODAL -->
<div class="modal fade" id="AddAdmin" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="material-symbols-rounded">add_circle</span>
                <h1 class="modal-title" id="exampleModalLabel">New Admin</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <fieldset>
                        <div class="mb-3">
                            <label for="Department" class="form-label">From what department?</label>
                            <select id="Department" class="form-select">
                                <option value="0" selected disabled>Select Department</option>
                                <?php
                                $query = mysqli_query($conn, "SELECT * FROM departments WHERE is_active=1 ORDER BY dept_uid");

                                while ($row = mysqli_fetch_array($query)) {
                                    $departmentName = $row['dept_uid'];
                                    $id = $row['uID'];
                                    echo '<option value="' . $id . '">' . $departmentName . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                        <div class="mb-3" id="employeeField" style="display: none;">
                            <label for="Employee" class="form-label">Which Employee?</label>
                            <input class="form-control" list="datalistOptions" id="Employee" placeholder="Enter Employee ID"
                                   autocomplete="off" oninput="autoInputHyphen(event)" />
                            <datalist id="datalistOptions">
                            </datalist>
                            <div class="mb-3">
                            <span id="InvalidEmployeeError" class="text-danger">
                            </span>
                            </div>
                        </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="addAdminButton">Add as Admin</button>
            </div>
        </div>
    </div>
</div>

<!-- REMOVE ADMIN MODAL -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="material-symbols-rounded">gpp_bad</span>
                <h1 class="modal-title" id="confirmModalLabel">Confirm Removal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3>Are you sure you want to remove admin <b><span id="adminName"></span></b>?</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="">Yes, Remove</button>
            </div>
        </div>
    </div>
</div>

<!-- JAVASCRIPT -->
<script>
    document.body.appendChild(document.getElementById('AddAdmin'));
    document.body.appendChild(document.getElementById('confirmModal'));
</script>
<script src="js/script_admins.js"></script>
