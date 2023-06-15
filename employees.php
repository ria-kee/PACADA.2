<?php
session_start();
$allowedPages = ['dashboard.php', 'departments.php', 'leave.php',
    'timeOff.php', 'admins.php', 'profile.php',
    'archived_departments.php', 'archived_employees.php']; // List of allowed pages

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
<link rel="stylesheet" href="css/style_employees.css">



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
            <a href="new_employee.php">
            <div class="grid-item button1" id="addEmployee">
                <span class="material-symbols-rounded">person_add</span>
                <button><h4  style="font-weight: normal;">Add Employee</h4></button>
            </div>
            </a>
            <a href="archived_employees.php">
                <div class="grid-item button2">
                    <span class="material-symbols-rounded">Inventory_2</span>
                    <h3>Archive</h3>
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
            <h3><b>ACTIVE EMPLOYEES</b></h3>
        </div>
        <table id="empTable" class="table table-striped" style="width:100%">
            <thead class="table-dark">
            <tr>
                <th rowspan="2">ID</th>
                <th rowspan="2">Department</th>
                <th rowspan="2">Name</th>
                <th colspan="4">CREDIT BALANCE</th>
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
</div>



<!--VIEW MODAL-->
<div class="modal fade amk right from-right delay-200" style="margin: unset;"  id="ViewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="material-symbols-rounded">info</span>
                <h1 class="modal-title" style="margin-left: 10px;">Employee Information</h1>
                <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">

                        <div class="upload">
                            <div class="upload-placeholder">
                                <img id="image" src="assets/img/no-profile.png" alt="Placeholder Image">
                            </div>
                        </div>
                        <div class="row" style="justify-content: center;">
                            <div style="text-align: center;">
                                <span type="text" id="name" style="text-align: center;">Name</span>
                            </div>
                            <div class="row" >
                                <div style="text-align: center; margin-bottom: 20px">
                                    <span type="text" id="department">Department</span>    |    <span type="text" id="uid" >ID</span>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3" style="text-align: center;  margin: 0;">
                                <label for="email" class="form-label"><b>Email: </b></label>
                                <span type="text"  id="email">email</span>
                            </div>
                        </div>

                        <!--divider-->
                        <hr  class="mt-1 mb-1" id="divider"/>

                        <div class="row" style = "margin-top: 25px; text-align: center;" >
                            <div class="col-md-6 mb-3">
                                <label for="sex" class="form-label" ><b>Sex: </b></label>
                                <span type="text"  id="sex">Sex</span>

                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="age" class="form-label"><b>Age: </b></label>
                                <span type="text"  id="age">Age</span>
                            </div>
                        </div>


                        <!--divider-->
                        <hr  class="mt-1 mb-1" id="divider"/>

                        <div class="row" style="margin-top: 15px">
                            <div class="col-md-12 mb-3" style="text-align: center;">
                                <label for="appdate" class="form-label"><b>Appointment Date: </b></label>
                                <span type="text"  id="appdate">Appointment Date</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="vacation" class="form-label"><b>Vacation Leave: </b></label>
                                <span type="text"  id="vacation">Vacation</span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="sick" class="form-label"><b>Sick Leave: </b></label>
                                <span type="text"  id="sick">Sick</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="force" class="form-label"><b>Force Leave: </b></label>
                                <span type="text" id="force">Force</span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="spl" class="form-label"><b>Special Leave: </b></label>
                                <span type="text"  id="spl">SPL</span>
                            </div>
                        </div>

                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary"  title="Leave and Time-Off History">View History</button>
            </div>
        </div>
    </div>
</div>

<!--EDIT MODAL-->
<div class="modal fade"  id="EditEmployee" tabindex="-1">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <span class="material-symbols-rounded">edit</span>
                <h1 class="modal-title" style="margin-left: 10px;">Edit Employee</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>

                    <div class="edit-upload">
                        <img id="preview-image" src="assets/img/no-profile.png" alt="Placeholder Image">
                        <div class="round">
                            <form id="photo" enctype="multipart/form-data">
                                <label for="formFile">
                                    <input class="form-control edit-input" type="file" id="formFile">
                                    <span id="boot-icon" class="bi bi-camera-fill" title="Upload Image" style="font-size: 1.5rem;color: #fff"></span>
                                </label>
                            </form>
                        </div>
                    </div>
                    <div class="text-center">
                        <span id="image-invalid-feedback" class="text-danger"></span>
                    </div>
                    <div class="text-center underline">
                        <span  id="RemoveImage" title="Remove Image">Remove Image</span>
                    </div>




                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-personal-tab" data-bs-toggle="tab" data-bs-target="#nav-personal" type="button" role="tab" aria-controls="nav-home" aria-selected="true"><span class="material-symbols-rounded">badge</span> Personal</button>
                            <button class="nav-link" id="nav-work-tab" data-bs-toggle="tab" data-bs-target="#nav-work" type="button" role="tab" aria-controls="nav-profile" aria-selected="false"><span class="material-symbols-rounded">work</span> Work</button>
<!--                            <button class="nav-link" id="nav-account-tab" data-bs-toggle="tab" data-bs-target="#nav-account" type="button" role="tab" aria-controls="nav-contact" aria-selected="false"><span class="material-symbols-rounded">settings_account_box</span> Account</button>-->
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-personal" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div class="row" style="margin-top: 15px;">
                                <div class="col-md-12 mb-3">
                                    <label for="fname" class="form-label">First Name</label>
                                    <input type="text" class="form-control edit-input" id="fname" placeholder="Enter First Name"  autocomplete="off" required>
                                    <span id="fname-invalid-feedback" class="text-danger"></span>

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="mname" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control edit-input" id="mname" placeholder="Enter Middle Name" autocomplete="off" >
                                    <span id="mname-invalid-feedback" class="text-danger"></span>

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lname" class="form-label">Last Name</label>
                                    <input type="text" class="form-control edit-input" id="lname" placeholder="Enter Last Name" autocomplete="off"  required>
                                    <span id="lname-invalid-feedback" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="sex" class="form-label">Sex</label>
                                    <select id="Editsex" class="form-select edit-input">
                                        <option value="0" selected disabled>Select Sex</option>
                                        <option value="M">Male</option>
                                        <option value="F">Female</option>
                                    </select>
                                    <span id="sex-invalid-feedback" class="text-danger"></span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="birthdate">Date of Birth</label>
                                    <input type="date" id="birthdate" class="form-control" required>
                                    <span id="bdate-invalid-feedback" class="text-danger"></span>
                                </div>


                            </div>


                        </div>
                        <div class="tab-pane fade" id="nav-work" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <form>
                                <div class="row" style="margin-top: 15px">

                                    <div class="col-md-6 mb-3" >
                                        <label for="Editdepartment" class="form-label">Assign Department</label>
                                        <select id="Editdepartment" class="form-select edit-input">
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
                                        <span id="dept-invalid-feedback" class="text-danger"></span>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="edit_appptdate">Appointment Date</label>
                                        <input type="date" id="edit_appptdate" class="form-control edit-input">
                                        <span id="appdate-invalid-feedback" class="text-danger"></span>
                                    </div>
                                </div>
                                <h3 style="color: var(--color-b3) ; margin-top: 10px"><b>Credit Balance</b></h3>
                                <hr class="mt-1 mb-1" id="divider"/>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="edit_vacation" class="form-label">Vacation Leave</label>
                                        <input type="number" step=".001"  min="0.000" class="form-control edit-input" id="edit_vacation" placeholder="Enter Vacation Leave Credit" value="0.000">
                                        <div class="mb-3">
                                            <span id="vacation-invalid-feedback" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="edit_sick" class="form-label">Sick Leave</label>
                                        <input type="number"  step=".001" min="0.000" class="form-control edit-input" id="edit_sick" placeholder="Enter Sick Leave Credit" value="0.000" >
                                        <div class="mb-3">
                                            <span id="sick-invalid-feedback" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="edit_force" class="form-label">Force Leave</label>
                                        <input type="number" step=".001" min="0.000" max="3" class="form-control edit-input" id="edit_force" placeholder="Enter Force Leave Credit" value="0.000">
                                        <div class="mb-3">
                                            <span id="force-invalid-feedback" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="edit_spl" class="form-label">Special Leave</label>
                                        <input type="number" step=".001" min="0.000" class="form-control edit-input" id="edit_spl" placeholder="Enter Special Leave Credit" value="0.000">
                                        <div class="mb-3">
                                            <span id="spl-invalid-feedback" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <input type="number" class="form-control" id="edit_uid" placeholder="uID" style="display: none">
                                </div>
                            </form>
                        </div>
<!--                        <div class="tab-pane fade" id="nav-account" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>-->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="UpdateEmployee">Confirm & Update Employee</button>
            </div>
        </div>
    </div>
</div>



<!--REMOVE EMPLOYEE MODAL-->
<div class="modal fade" id="EmployeeArchiveModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
     aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="material-symbols-rounded">inventory_2</span>
                <h1 class="modal-title" id="confirmModalLabel">Confirm Deactivation</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3>Are you sure you want to deactivate <b><span id="empname"></span></b> ?</h3>
                <h5 style="font-family: 'Poppins Light'">You can view the inactive employees by clicking the "Archive" button.</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="yes" onclick="">Yes, Deactivate</button>
            </div>
        </div>
    </div>
</div>






<!-- JAVASCRIPT -->
<script src="js/script_employees.js"></script>