<?php
session_start();
$allowedPages = ['dashboard.php', 'departments.php', 'employees.php',
    'leave.php', 'timeOff.php', 'admins.php',
    'profile.php', 'credits.php', 'archived_departments.php', 'archived_employees.php']; // List of allowed pages

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
<link rel="stylesheet" href="css/style_logs.css">

<!--EXPORT-->
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>


<?php include_once "header/active_employees.php"; ?>
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

                <h3><a href="employees.php">Employees</a><i class="bi bi-chevron-right"></i><b style="color: var(--color-p3">View History</b> </h3>
            </div>
            <a href="employees.php">
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
                <div class="search">
                    <span class="material-symbols-rounded">search</span>
                    <input type="text" class="searchField" placeholder="Search for date, leave type, or etc.">
                </div>
            </div>
        </div>

    </div>
    <div class="tablead">
        <div class="table-top" style="display: flex; justify-content: center;">
            <h3 style="font-size: 25px; margin-bottom: 15px; text-align: center;"><b id="employee-name"></b></h3>
        </div>

        <nav>
            <div class="nav nav-tabs nav-justified" id="nav-tab" role="tablist">
                <button class="nav-link active" style="font-size: 14px" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                    <span class="material-symbols-rounded" style="font-size: 18px; ">event_upcoming</span>Leaves</button>
                <button class="nav-link" style="font-size: 14px" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                    <span class="material-symbols-rounded" style="font-size: 18px;">work_history</span>Time-offs</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                <table id="leavesTable" class="table table-striped" style="width:100%; margin-top: 20px">
                    <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Filed by</th>
                        <th>Filed at</th>
                        <th>Remarks</th>
                    </tr>
                    </thead>

                    <tbody class="table-striped">
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <table id="timeoffsTable" class="table table-striped" style="width:100%; margin-top: 20px">
                    <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Claimed Time</th>
                        <th>Filed By</th>
                        <th>Remarks</th>
                    </tr>
                    </thead>

                    <tbody class="table-striped">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
<script src="js/script_history.js"></script>
<script src="js/script_session-timeout.js"></script>