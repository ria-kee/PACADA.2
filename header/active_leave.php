<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave</title>
    <link rel="icon" href="assets/PACADA/PACADA.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="css/style_dashboard.css">
</head>
<body style="z-index: -3; position: relative">
<div class="container" style="z-index: -2; position: relative">
    <div class="background"></div>
    <div class="header header-grid">
        <div class="location">
            <h1 class="location">Leave</h1>
        </div>
        <?php include_once "header_userInfo.php"?>
    </div>
    <aside>
        <?php
        $isSuperAdmin = $_SESSION['is_superadmin'] ?? 0; // Get the value of $_SESSION['is_superadmin'] or set it to 0 if not set

        if ($isSuperAdmin === 0) {
            // User is not a super admin, hide the link
            $linkStyle = 'display: none;';
        } else {
            // User is a super admin, show the link
            $linkStyle = '';
        }
        ?>
        <div class="top">
            <div class="logo">
                <img src="assets/PACADA/PACADA.png" alt="PACADA icon">
                <h2 >PACADA</h2>
            </div>
            <div class="close" id="close-btn">
                <i class="material-symbols-rounded">close</i>
            </div>
        </div>

        <div class="sidebar">
            <a href="dashboard.php" >
                <span class="material-symbols-rounded">grid_view</span>
                <h3>Dashboard</h3>
            </a>

            <a href="departments.php">
                <span class="material-symbols-rounded">domain</span>
                <h3>Departments</h3>
            </a>

            <a href="employees.php">
                <span class="material-symbols-rounded">badge</span>
                <h3>Employees</h3>
            </a>

            <a href="leave.php" class="active">
                <span class="material-symbols-rounded">event_upcoming</span>
                <h3>Leave</h3>
            </a>

            <a href="timeOff.php">
                <span class="material-symbols-rounded">work_history</span>
                <h3>Time-Off</h3>
            </a>

            <a href="admins.php" style="<?php echo $linkStyle; ?>">
                <span class="material-symbols-rounded">manage_accounts</span>
                <h3>Admins</h3>
            </a>
            <a href="profile.php">
                <span class="material-symbols-rounded">person</span>
                <h3>Profile</h3>
            </a>
            <a href="#" id="logoutLink">
                <span class="material-symbols-rounded">logout</span>
                <h3>Logout</h3>
            </a>
        </div>
    </aside>

    <!--LOGOUTMODAL-->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #DF4759">
                    <span class="material-symbols-rounded">logout</span>
                    <h1 class="modal-title" id="confirmModalLabel">Confirm Log Out</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3>Do you really want to log out?</h3>
                </div>
                <div class="modal-footer">
                    <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" id="confirmLogout" class="btn btn-danger" onclick="">Yes</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.getElementById("logoutLink").addEventListener("click", function(event) {
            event.preventDefault(); // Prevent the default link behavior

            // Show the confirmation modal
            $('#confirmationModal').modal('show');
        });

        document.getElementById("confirmLogout").addEventListener("click", function() {
            // Redirect to the logout page
            window.location.href = "logout.php";
        });
    </script>


    <script>
        document.body.appendChild(document.getElementById('confirmationModal'));
    </script>
