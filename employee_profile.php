<?php
session_start();
$allowedPages = ['employee_dashboard.php', 'employee_history.php', 'employee_timeoff.php']; // List of allowed pages

$currentFile = basename($_SERVER['PHP_SELF']); // Get the name of the current PHP file

// Check if the user is not logged in and the current page is not in the allowed pages list
if (!isset($_SESSION['employee_uID']) && !in_array($currentFile, $allowedPages)) {
    // Redirect the user to the login page or show access denied message
    header('Location: error.401-employee.php');
    exit();
}
?>

<?php include_once "header_employee/emp.active_profile.php"; ?>
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

<div class="entire-container">
    <div class="main">
        <div class="center_container">
            <div class="image-circle">
                <img src="data:image/jpeg;base64,<?php echo $_SESSION['employee_Profile']; ?>" alt="User Profile">
            </div>

            <?php
            $empName = ucwords(strtolower($_SESSION['employee_FirstName'])) . ' ';

            if (!empty($_SESSION['employee_MiddleName'])) {
                $empName .= strtoupper(substr($_SESSION['employee_MiddleName'], 0, 1)) . '. ';
            }

            $empName .= ucwords(strtolower($_SESSION['employee_LastName']));
            ?>
            <div class="name">
                <h2><?php echo $empName?></h2>
            </div>

            <div class="email">
                <h3><?php echo $_SESSION['employee_email']?></h3>
            </div>

            <button type="button" class="btn btn-outline-primary" id="changePassBtn" data-bs-toggle="modal" data-bs-target="#ChangePassModal" style="width: max-content; font-size: small; margin-top: 10px;">Change Password</button>
        </div>

    </div>
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



                <label for="Password" class="form-label" style="font-size: 14px">Current Password</label>
                <div class="input-group">

                    <input type="password" class="form-control" id="current_password" placeholder="Enter Current Password" style="font-size: 13px;">
                    <button class="btn btn-outline-primary" type="button" id="current_passwordToggle" onclick="CurrentTogglePasswordVisibility()">
                        <i class="bi bi-eye-slash-fill" style="font-size: 16px;"></i>
                    </button>
                </div>
                <span id="current-invalid-feedback" class="text-danger" style="font-size: small"></span> <br/>





                <label for="Password" class="form-label" style="margin-top: 1rem; font-size: 14px" >New Password</label>
                <div class="input-group">

                    <input type="password" class="form-control" id="new_password" placeholder="Enter New Password" style="font-size: 13px;">
                    <button class="btn btn-outline-primary" type="button" id="new_passwordToggle" onclick="togglePasswordVisibility()">
                        <i class="bi bi-eye-slash-fill" style="font-size: 16px"></i>
                    </button>
                </div>
                <span id="new-invalid-feedback" class="text-danger" style="font-size: small"></span> <br/>

                <label for="Password" class="form-label" style="margin-top: 1rem; font-size: 14px" >Confirm New Password</label>
                <div class="input-group">

                    <input type="password" class="form-control" id="confirm_password" placeholder="Confirm New Password" style="font-size: 13px;">
                    <button class="btn btn-outline-primary" type="button" id="confirm_passwordToggle" onclick="ConfirmTogglePasswordVisibility()">
                        <i class="bi bi-eye-slash-fill" style="font-size: 16px"></i>
                    </button>
                </div>
                <span id="confirm-invalid-feedback" class="text-danger" style="font-size: small"></span> <br/>



                <div class="mb-3">
                    <span id="force-invalid-feedback" class="text-danger"></span>
                </div>
            </div>
            <div class="modal-footer" style="margin: 2px">
                <button type="button" class="btn btn-secondary"  style="width: 15%; font-size: 13px" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary"style="width: 25%; font-size: 13px"  id="saveChanges" onclick="">Save Changes</button>
            </div>
        </div>
    </div>
</div>


<script src="js_employee/emp.script_profile.js"></script>