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
<link rel="stylesheet" href="css/style_add_employee.css">

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
                <h3><a href="employees.php">Employees</a><i class="bi bi-chevron-right"></i><b style="color: var(--color-p3">Add Employee</b> </h3>
            </div>

            <a href="employees.php">
                <div class="grid-item button2">
                    <span class="material-symbols-rounded">arrow_back</span>
                    <h3>Go Back</h3>
                </div>
            </a>
        </div>
        <div class="grid-container body-item">
            <div class="containers">
               <div class="steps">
                   <span class="circle" id="c1">1</span>
<!--                   <span class="material-symbols-rounded">done</span>-->
                   <span class="circle" id="c2">2</span>
                   <span class="circle" id="c3">3</span>
                   <div class="progress">
                       <span class="indicator"></span>
                   </div>
               </div>

                <div class="label">
                    <span id="l1">Personal</span>
                    <span id="l2">Work</span>
                    <span id="l3">Account</span>
                </div>


            </div>

        </div>

    </div>
    <div class="tablead">
        <div id="personal" class="page" data-page="1" style="display: block">
        <div class="table-top">
            <h2 class="title" style="color: var(--color-p3)"><b> <span class="material-symbols-rounded">badge</span> Personal Information</b></h2>
            <div class="buttons-right">
<!--                    <button class="prev btn-secondary" id="prev-button" title="Activate all selected" disabled>Prev</button>-->
                    <button class="next btn-primary"  id="next-button" title="Go to Work Information">Next</button>
            </div>
        </div>
        <!--divider-->
        <hr class="mt-1 mb-1" id="divider"/>

            <div class="upload">
                <div class="upload-placeholder">
                    <img id="preview-image" src="assets/img/no-profile.png" alt="Placeholder Image">
                </div>
                <div class="col-md-4 mb-3">
<!--                    <label for="formFile" class="form-label">Upload Image</label>-->
                    <input class="form-control" type="file" id="formFile">
                    <span id="invalid-feedback" class="text-danger"></span>
                </div>
            </div>

            <!--divider-->
            <hr class="mt-1 mb-1" id="divider"/>
            <form class="form-control">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="fname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="fname" placeholder="Enter First Name" required>
                            <span id="fname-invalid-feedback" class="text-danger"></span>

                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="mname" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="mname" placeholder="Enter Middle Name">
                            <span id="mname-invalid-feedback" class="text-danger"></span>

                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="lname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lname" placeholder="Enter Last Name" required>
                            <span id="lname-invalid-feedback" class="text-danger"></span>
                    </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="sex" class="form-label">Sex</label>
                    <select id="sex" class="form-select">
                        <option value="0" selected disabled>Select Sex</option>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select>
                    <span id="sex-invalid-feedback" class="text-danger"></span>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="birthdate">Date of Birth</label>
                    <input type="date" id="birthdate" class="form-control" required>
                    <span id="bdate-invalid-feedback" class="text-danger"></span>
                </div>


            </div>
            </form>

        </div>
        <div id="work" class="page" data-page="2"  style="display: none">
            <div class="table-top">
                <h2 class="title" style="color: var(--color-p3)"><span class="material-symbols-rounded">work</span><b> Work Information</b></h2>
                <div class="buttons-right">
                    <button class="prev btn-secondary" id="prev-button2" title="Go back to Personal Information">Prev</button>
                    <button class="next btn-primary"  id="next-button2" title="Go to Account Information">Next</button>
                </div>
            </div>
            <!--divider-->
            <hr class="mt-1 mb-1" id="divider"/>
            <form>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="empID">ID</label>
                        <input type="text" id="empID" class="form-control"  placeholder="ex.ABC-1213 / ABCD-1213" oninput="autoInputHyphen(event)" autocomplete="off">
                        <span id="empID-invalid-feedback" class="text-danger"></span>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="Department" class="form-label">Assign Department</label>
                        <select id="dept" class="form-select">
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

                    <div class="col-md-4 mb-3">
                        <label for="apptdate">Appointment Date</label>
                        <input type="date" id="appptdate" class="form-control">
                        <span id="apptdate-invalid-feedback" class="text-danger"></span>
                    </div>



                </div>






                <h3 style="color: var(--color-b3) ; margin-top: 10px"><b>Credit Balance</b></h3>
                <hr class="mt-1 mb-1" id="divider"/>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="vacation" class="form-label">Vacation Leave</label>
                        <input type="number" step=".001"  min="0.000" class="form-control" id="vacation" placeholder="Enter Vacation Leave Credit" value="0.000">
                        <div class="mb-3">
                            <span id="vacation-invalid-feedback" class="text-danger"></span>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="sick" class="form-label">Sick Leave</label>
                        <input type="number"  step=".001" min="0.000" class="form-control" id="sick" placeholder="Enter Sick Leave Credit" value="0.000" >
                        <div class="mb-3">
                            <span id="sick-invalid-feedback" class="text-danger"></span>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="force" class="form-label">Force Leave</label>
                        <input type="number" step=".001" min="0.000" max="3" class="form-control" id="force" placeholder="Enter Force Leave Credit" value="0.000">
                        <div class="mb-3">
                            <span id="force-invalid-feedback" class="text-danger"></span>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="spl" class="form-label">Special Leave</label>
                        <input type="number" step=".001" min="0.000" class="form-control" id="spl" placeholder="Enter Special Leave Credit" value="0.000">
                        <div class="mb-3">
                            <span id="spl-invalid-feedback" class="text-danger"></span>
                        </div>
                    </div>

                </div>

            </form>


        </div>
        <div id="account" class="page" data-page="3"  style="display: none" >
            <div class="table-top">
                <h2 class="title" style="color: var(--color-p3)"><b><span class="material-symbols-rounded">settings_account_box</span> Account Information</b></h2>
                <div class="buttons-right">
                    <button class="prev btn-secondary" id="prev-button3" title="Go Back to Work Information">Prev</button>
                    <button class="next" id="save" title="Add Employee">Save</button>
                </div>
            </div>
            <!--divider-->
            <hr class="mt-1 mb-1" id="divider"/>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter Email Address" required>
                        <span id="email-invalid-feedback" class="text-danger"></span>
                </div>


                <div class="col-md-6 mb-3">
                    <div class="input-group-prepend">
                        <label for="Password" class="form-label">Password</label>
                        <input type="text" class="form-control" id="password" placeholder="Enter Last Name" readonly>
                    </div>
            </div>

            </div>
    </div>

    </div>



    <!-- REVIEW MODAL -->
    <div class="modal fade" id="ReviewModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="material-symbols-rounded">preview</span>
                    <h1 class="modal-title" style="margin-left: 10px;">Employee Preview</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">

                            <div class="upload">
                                <div class="upload-placeholder">
                                    <img id="preview-image" src="assets/img/no-profile.png" alt="Placeholder Image">
                                </div>
                            </div>
                            <div class="row">

                                <div style="text-align: center;">
                                    <span type="text" id="review_fullname">Name</span>
                                </div>
                            <div class="row">
                                <div style="text-align: center; margin-bottom: 20px">
                                    <span type="text" id="review_department">Department</span>    |    <span type="text" id="review_id" >ID</span>
                                </div>
                            </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3" style="text-align: center;  margin: 0;">
                                    <label for="review_email" class="form-label"><b>Email: </b></label>
                                    <span type="text"  id="review_email">email</span>
                                </div>
                                <div class="col-md-12 mb-3" style="text-align: center; margin: 0;">
                                    <label for="review_password" class="form-label"><b>Password: </b></label>
                                    <span type="text" id="review_password">Password</span>
                                </div>
                            </div>

                            <!--divider-->
                            <hr  class="mt-1 mb-1" id="divider"/>

                            <div class="row" style = "margin-top: 25px;" >
                                <div class="col-md-6 mb-3">
                                    <label for="review_sex" class="form-label" ><b>Sex: </b></label>
                                    <span type="text"  id="review_sex">Sex</span>

                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="review_birthdate" class="form-label"><b>Date of Birth: </b></label>
                                    <span type="text"  id="review_birthdate">Date of Birth</span>
                                </div>
                            </div>


                            <!--divider-->
                            <hr  class="mt-1 mb-1" id="divider"/>

                            <div class="row">
                                <div class="col-md-12 mb-3" style="text-align: center;">
                                    <label for="review_appdate" class="form-label"><b>Appointment Date: </b></label>
                                    <span type="text"  id="review_appdate">Appointment Date</span>
                                </div>
                            </div>
                           <div class="row">
                               <div class="col-md-6 mb-3">
                                   <label for="review_vacation" class="form-label"><b>Vacation Leave: </b></label>
                                   <span type="text"  id="review_vacation">Vacation</span>
                               </div>
                               <div class="col-md-6 mb-3">
                                   <label for="review_sick" class="form-label"><b>Sick Leave: </b></label>
                                   <span type="text"  id="review_sick">Sick</span>
                               </div>
                           </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="review_force" class="form-label"><b>Force Leave: </b></label>
                                    <span type="text" id="review_force">Force</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="review_spl" class="form-label"><b>Special Leave: </b></label>
                                    <span type="text"  id="review_spl">SPL</span>
                                </div>
                            </div>

                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Wait , Edit Details</button>
                    <button type="button" class="btn btn-primary" id="addDepartmentButton">Proceed , Add Employee</button>
                </div>
            </div>
        </div>
    </div>



<!-- JAVASCRIPT -->
<script src="js/script_add_employee.js"></script>