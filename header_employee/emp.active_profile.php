<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="icon" href="assets/PACADA/PACADA.png">

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
    <link rel="stylesheet" href="css_employee/style_nav.css">

    <!--EXPORT-->
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>





    <title>Profile</title>
</head>
<body>
<header>
    <div class="logo">
        <img src="assets/PACADA/emp_logo.png" alt="">
    </div>
    <input type="checkbox" id="nav_check" hidden>
    <nav>
        <div class="logo">
            <img src="assets/PACADA/emp_logo.png" alt="">
        </div>
        <ul>
            <li>

                <a href="employee_dashboard.php" ><span class="material-symbols-outlined">
                                      dashboard
                                      </span>Dashboard</a>
            </li>

            <li>
                <a href="employee_history.php" ><span class="material-symbols-outlined">
                                      history
                                      </span>History</a>
            </li>

            <li>
                <a href="employee_profile.php" class="active">
                                      <span class="material-symbols-outlined">
                                      person
                                      </span>Profile</a>
            </li>

            <li>
                <a href="#" id="logoutLink"><span class="material-symbols-outlined">
                                      logout
                                      </span>Logout</a>
            </li>
        </ul>
    </nav>
    <label for="nav_check" class="hamburger">
        <div></div>
        <div></div>
        <div></div>
    </label>
</header>

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
        window.location.href = "employee_logout.php";
    });
</script>


<script>
    document.body.appendChild(document.getElementById('confirmationModal'));
</script>
<script src="js_employee/script_nav.js"></script>