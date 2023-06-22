<?php
session_start();
$allowedPages = ['dashboard.php', 'departments.php', 'employees.php',
    'leave.php', 'timeOff.php', 'admins.php',
    'profile.php', 'archived_employees.php' ,'archived_departments.php']; // List of allowed pages

$currentFile = basename($_SERVER['PHP_SELF']); // Get the name of the current PHP file

 include('includes/dbh.inc.php');
$resetQuery = "UPDATE employees
                           SET credit_isUpdated = 0
                           WHERE MONTH(credit_updateDate) <> MONTH(CURRENT_DATE())";
$resetResult = mysqli_query($conn, $resetQuery);



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
<link rel="stylesheet" href="css/style_credits.css">

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
        <div class="button-container body-item">
            <div class="grid-item actions">

                <h3><a href="leave.php">Leave</a><i class="bi bi-chevron-right"></i><b style="color: var(--color-p3">Record Late</b> </h3>
            </div>
            <a href="leave.php">
                <div class="grid-item button2">
                    <span class="material-symbols-rounded">arrow_back</span>
                    <h3>Go Back</h3>
                </div>
            </a>
        </div>
        <div class="grid-container body-item">
            <div class="grid-item">
                <h3>What are you looking for?</h3>
            </div>
            <div class="grid-item">
                <h3>What Department?</h3>
            </div>
            <div class="grid-item">
                <div class="search">
                    <span class="material-symbols-rounded">search</span>
                    <input type="text" class="searchField" placeholder="Search for name, id, or etc.">
                </div>
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

    </div>
    <div class="tablead">
        <div class="table-top" style="display: flex; justify-content: center;">
            <h3 style="font-size: 25px; margin-bottom: 15px; text-align: center;"><b class="Datetitle"></b></h3>
        </div>

        <nav>
            <div class="nav nav-tabs nav-justified" id="nav-tab" role="tablist">
                <button class="nav-link active" style="font-size: 14px" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                    <span class="material-symbols-rounded" style="font-size: 18px; ">pending</span>Pending</button>
                <button class="nav-link" style="font-size: 14px" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                    <span class="material-symbols-rounded" style="font-size: 18px;">check_circle</span>Updated</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                <table id="creditTable" class="table table-striped" style="width:100%; margin-top: 20px">
                    <thead class="table-dark">
                    <tr>
                        <th rowspan="2">ID</th>
                        <th rowspan="2">Department</th>
                        <th rowspan="2">Name</th>
                        <th colspan="4">CREDIT BALANCE</th>
                        <th rowspan="2">Last Update</th>
                        <th rowspan="2">Options</th>
                    </tr>
                    <tr>
                        <th>Vacation</th>
                        <th>Sick</th>
                        <th>Force</th>
                        <th>SPL</th>
                    </tr>
                    </thead>

                    <tbody class="table-striped">
                    </tbody>
                </table>





            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <table id="updatedcreditTable" class="table table-striped" style="width:100%; margin-top: 20px">
                    <thead class="table-dark">
                    <tr>
                        <th rowspan="2">ID</th>
                        <th rowspan="2">Department</th>
                        <th rowspan="2">Name</th>
                        <th colspan="4">CREDIT BALANCE</th>
                        <th rowspan="2">Last Update</th>
                    </tr>
                    <tr>
                        <th>Vacation</th>
                        <th>Sick</th>
                        <th>Force</th>
                        <th>SPL</th>
                    </tr>
                    </thead>

                    <tbody class="table-striped">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- ADD CREDIT MODAL -->
<div class="modal fade" id="AddCreditModal" tabindex="1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="material-symbols-rounded">avg_pace</span>
                <h1 class="modal-title" style="margin-left: 10px;">Record Late</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>

                    <div class="employee">
                        <div class="upload">
                            <div class="upload-placeholder">
                                <img id="image" >
                            </div>
                        </div>
                        <h2 id="empname"></h2>
                        <h3 id="dept" style="font-size: 18px"></h3>
                    </div>



                    <div class="form-group" style="margin-top: 15px">
                        <div class="input-group">
                            <input type="number" id="late" min="0" max="0.9" step="0.001" class="form-control" id="minutesLate" value="0.000" placeholder="Enter Total Minutes Late">
                            <div class="input-group-append">
                                <span class="input-group-text">Equiv. Day</span>
                            </div>
                        </div>
                        <span id="late-invalid-feedback" class="text-danger"></span>

                    </div>

                    <div class="form-group" style="margin-top: 15px">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="vacation" class="form-label">Accumulated Vacation Credits</label>
                                <input type="text" class="form-control" id="vacation" value="1.25" readonly>

                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="sick" class="form-label">Accumulated Sick Credits</label>
                                <input type="text" class="form-control" id="sick" value="1.25" readonly>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="AddCredits">Add Credits</button>
            </div>
        </div>
    </div>
</div>

<!-- JAVASCRIPT -->
<script>
    document.body.appendChild(document.getElementById('AddCreditModal'));
</script>
<script src="js/script_credits.js"></script>