<?php
session_start();
$allowedPages = ['dashboard.php', 'departments.php', 'employees.php',
    'timeOff.php', 'admins.php', 'profile.php',
    'archived_departments.php', 'credits.php', 'archived_employees.php']; // List of allowed pages

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

<!--SIDE BAR MODAL-->
<link href="https://staging.appcropolis.com/functions/preview/appcropolis/amk-source/main.css" rel="stylesheet">
<!-- CUSTOM CSS -->
<link rel="stylesheet" href="css/style_leave.css">



<!--EXPORT-->
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>


<?php include_once "header/active_leave.php"; ?>
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

            <div class="grid-item" >
                <h3>Search for?</h3>
            </div>

            <div class="grid-item">
                <h3>Start Date</h3>
            </div>

            <div class="grid-item" style="margin-left: 19px">
                <h3>End Date</h3>
            </div>


            <div class="grid-item">
                <h3>What Department?</h3>
            </div>
            <div class="grid-item">
                <div class="search">
                    <span class="material-symbols-rounded">search</span>
                    <input type="text" class="searchField" placeholder="name, department, etc.">
                </div>
            </div>

            <div class="grid-item">
                <input type="date" id="from-date" class="form-control date">
            </div>

            <div class="grid-item">
                <h3>-</h3>
            </div>

            <div class="grid-item">
                <input type="date" id="to-date" class="form-control date">
            </div>



            <div class="grid-item">
                <div class="dropdown">
                    <select id="Department" class="form-select">
                        <option value="0" selected>All</option>
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
            </div>
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

            <div class="grid-item">
                <div class="dropdown">
                    <button class="btn button1 dropdown-toggle " type="button" id="quick-action"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        Select Action
                    </button>
                    <ul class="dropdown-menu" id="quick-dropdown" aria-labelledby="dropdownMenuButton">
                        <li><a href="credits.php" class="dropdown-item d-flex justify-content-between align-items-center"  id="add-credit">
                                <span>Record Late</span>
                                <span class="material-symbols-rounded" style="font-size: 18px">avg_pace</span>
                            </a>
                        </li>
                        <li><a href="file_leave.php" class="dropdown-item d-flex justify-content-between align-items-center"  id="file-leave">
                                <span>File Leave</span>
                                <span class="material-symbols-rounded" style="font-size: 18px">event</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div>

            </div>




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
            <h3><b>FILED LEAVES</b></h3>
        </div>
        <table id="leaveTable" class="table table-striped" style="width:100%">
            <thead class="table-dark">
            <tr>
                <th >Date</th>
                <th >Name</th>
                <th >Department</th>
                <th >Leave Type</th>
                <th >Created At</th>
                <th >Filed By</th>
                <th >Remarks</th>
                <th >Options</th>

            </tr>
            </thead>

            <tbody class="table-striped">
            </tbody>
        </table>
    </div>
</div>




<!-- JAVASCRIPT -->
<script src="js/script_leave.js"></script>