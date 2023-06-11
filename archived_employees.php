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
<link rel="stylesheet" href="css/style_archive_employees.css">

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

                <h3><a href="employees.php">Employees</a><i class="bi bi-chevron-right"></i><b style="color: var(--color-p3">Archive</b> </h3>
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
                    <input type="text" class="searchField" placeholder="Search for name, id, or etc.">
                </div>
            </div>
        </div>

    </div>
    <div class="tablead">
        <div class="table-top">
            <h3 class="title"><b>INACTIVE EMPLOYEES</b></h3>
            <div class="buttons-right">
                <div class="activate">
                    <button class="activateall" data-toggle="modal" data-target="#ActivateAll" id="activateAllButton" title="Activate all selected"> <h2><i class="bi bi-person-check"></i> </h2></button>
                </div>
                <div class="delete">
                    <button class="deleteall" data-toggle="modal" data-target="#DeleteAll" id="deleteAllButton" title="Delete all selected"> <h2><i class="bi bi-trash"></i> </h2></button>
                </div>
            </div>
        </div>
        <table id="empTable" class="table table-striped" style="width:100%">
            <thead class="table-dark">
            <tr>
                <th rowspan="2"><input class="form-check-input" type="checkbox" value="0" id="selectAllCheckbox"></th>
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


<!--Delete DEPT MODAL-->
<div class="modal fade" id="DeleteEmp" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="material-symbols-rounded">Delete</span>
                <h1 class="modal-title" id="confirmModalLabel">Confirm Permanent Deletion</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3>Are you sure you want to <b class="text-danger">permanently delete</b> <b><span id="deptName"></span></b>?</h3>
                <h5 style="font-family: 'Poppins Light'">This action cannot be undone.</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="yess" class="btn btn-danger" onclick="">Yes, Delete Permanently</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="DeleteAll" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="material-symbols-rounded">delete</span>
                <h1 class="modal-title" id="confirmModalLabel">Confirm Permanent Deletion</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3>Are you sure you want to  <b class="text-danger">permanently delete</b> all selected <span id="deptName"></span> departments ?</h3>
                <h5 style="font-family: 'Poppins Light'">This action cannot be undone.</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="yes" class="btn btn-danger" onclick="">Yes, Delete Permanently</button>
            </div>
        </div>
    </div>
</div>



<!--VIEW EMPLOYEE-->
<div class="modal fade" id="ReviewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="material-symbols-rounded">info</span>
                <h1 class="modal-title" style="margin-left: 10px;">Employee Preview</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">

                        <div class="upload">
                            <div class="upload-placeholder">
                                <img id="review-preview-image" src="assets/img/no-profile.png" alt="Placeholder Image">
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
<!--                            <div class="col-md-12 mb-3" style="text-align: center; margin: 0;">-->
<!--                                <label for="review_password" class="form-label"><b>Password: </b></label>-->
<!--                                <span type="text" id="review_password">Password</span>-->
<!--                            </div>-->
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>







<!-- JAVASCRIPT -->
<script src="js/script_archivedEmp.js"></script>