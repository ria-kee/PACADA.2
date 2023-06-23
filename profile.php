<?php
session_start();
$allowedPages = ['dashboard.php', 'departments.php', 'employees.php',
    'leave.php', 'timeOff.php', 'admins.php',
    'archived_departments.php', 'archived_employees.php','view_logs.php']; // List of allowed pages

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
<link rel="stylesheet" href="css/style_profile.css">

<!--EXPORT-->
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>


<?php include_once "header/active_profile.php"; ?>
<?php include('includes/dbh.inc.php'); ?>


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


<div class="center_container">
        <div class="image-circle">
            <img src="data:image/jpeg;base64,<?php echo $_SESSION['admin_Profile']; ?>" alt="User Profile">
        </div>

    <?php
    $empName = ucwords(strtolower($_SESSION['admin_FirstName'])) . ' ';

    if (!empty($_SESSION['admin_MiddleName'])) {
        $empName .= strtoupper(substr($_SESSION['admin_MiddleName'], 0, 1)) . '. ';
    }

    $empName .= ucwords(strtolower($_SESSION['admin_LastName']));
    ?>
        <div class="name">
            <h2><?php echo $empName?></h2>
        </div>

    <div class="email">
        <h3><?php echo $_SESSION['admin_email']?></h3>
    </div>

    <small class="text-muted" style="font-size: 11px">
        <?php
        if($_SESSION['is_superadmin'] === 1){
            echo 'Super Administrator';
        }
        else{
            echo 'Administrator';
        }
        ?></small>
    <button type="button" class="btn btn-outline-secondary" id="yes" onclick="" style="margin-top:1rem">View My Logs</button>

    <button type="button" class="btn btn-outline-primary" id="changePassBtn" data-bs-toggle="modal" data-bs-target="#ChangePassModal" style="margin-top: 0.5rem">Change Password</button>
</div>



<!--CHANGE PASSWORD MODAL-->
<div class="modal fade" id="ChangePassModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
     aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="material-symbols-rounded">lock_reset  </span>
                <h1 class="modal-title" id="confirmModalLabel">Change Password</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">





                <label for="Password" class="form-label" >Current Password</label>
                <div class="input-group">

                    <input type="password" class="form-control" id="current_password" placeholder="Enter Current Password">
                    <button class="btn btn-outline-primary" type="button" id="current_passwordToggle" onclick="CurrentTogglePasswordVisibility()">
                        <i class="bi bi-eye-slash-fill"></i>
                    </button>
                </div>
                <span id="current-invalid-feedback" class="text-danger"></span> <br/>





                <label for="Password" class="form-label" style="margin-top: 1rem" >New Password</label>
                <div class="input-group">

                    <input type="password" class="form-control" id="new_password" placeholder="Enter New Password">
                    <button class="btn btn-outline-primary" type="button" id="new_passwordToggle" onclick="togglePasswordVisibility()">
                        <i class="bi bi-eye-slash-fill"></i>
                    </button>
                </div>
                <span id="new-invalid-feedback" class="text-danger"></span> <br/>

                <label for="Password" class="form-label" style="margin-top: 1rem" >Confirm New Password</label>
                <div class="input-group">

                    <input type="password" class="form-control" id="confirm_password" placeholder="Confirm New Password">
                    <button class="btn btn-outline-primary" type="button" id="confirm_passwordToggle" onclick="ConfirmTogglePasswordVisibility()">
                        <i class="bi bi-eye-slash-fill"></i>
                    </button>
                </div>
                <span id="confirm-invalid-feedback" class="text-danger"></span> <br/>



                <div class="mb-3">
                    <span id="force-invalid-feedback" class="text-danger"></span>
                </div>
            </div>
            <div class="modal-footer" style="margin: 2px">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveChanges" onclick="">Save Changes</button>
            </div>
        </div>
    </div>
</div>






<!-- JAVASCRIPT -->
<script>
    document.body.appendChild(document.getElementById('ChangePassModal'));
</script>
<script src="js/script_profile.js"></script>