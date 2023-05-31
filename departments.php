<!-- jQuery CDN Library -->
<script src="/js/bootstrap/jquery-3.6.0.min.js"></script>
<!-- BOOTSTRAP LIBRARY -->
<link rel="stylesheet" href="/css/bootstrap/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<script src="/js/bootstrap/bootstrap.bundle.min.js"></script>
<!-- DATATABLE LIBRARY -->
<link rel="stylesheet" href="/css/bootstrap/datatables.min.css">
<script src="/js/bootstrap/datatables.min.js"></script>
<!-- CUSTOM CSS -->
<link rel="stylesheet" href="/css/style_department.css">

<!--EXPORT-->
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>


<?php include_once "header/active_departments.php"; ?>
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
                <div class="search">
                    <span class="material-symbols-rounded">search</span>
                    <input type="text" class="searchField" placeholder="Search for name, id, or etc.">
                </div>
            </div>
        </div>



        <div class="button-container body-item">
            <div class="grid-item actions">
                <span class="material-symbols-rounded">sprint</span>
                <h3>Quick Action</h3>
            </div>
            <div class="grid-tem"></div>
            <div class="grid-tem actions">
                <span class="material-symbols-rounded">download</span>
                <h3>Export Table</h3>
            </div>
            <div class="grid-item button1" data-bs-toggle="modal" data-bs-target="#AddDept">
                <span class="material-symbols-rounded">add</span>
                <button><h4  style="font-weight: normal;">Add Department</h4></button>
            </div>

            <div class="vl"></div>
            <div class="grid-item">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        File Type
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" type="button" id="excelExport">Excel</a></li>
                        <li><a class="dropdown-item" type="button" id="pdfExport">PDF</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="tablead">
        <table id="deptTable" class="table table-striped" style="width:100%">
            <thead class="table-dark">
                <th>Acronym</th>
                <th>Department</th>
                <th class="options">Options</th>
            </thead>

            <tbody class="table-striped">
            </tbody>
        </table>
    </div>
</div>


<!-- ADD DEPT MODAL -->
<div class="modal fade" id="AddDept" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="material-symbols-rounded">domain_add</span>
                <h1 class="modal-title" style="margin-left: 10px;">New Department</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="Acronym" class="form-label">Acronym</label>
                            <input type="text" class="form-control" id="Acronym" placeholder="Enter Department Acronym" required>
                            <div class="mb-3">
                                <span id="invalid-feedback" class="text-danger"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="mb-3">
                            <label for="Department" class="form-label">Department</label>
                            <input type="text" class="form-control" id="Department" placeholder="Enter Department Name" required>
                            <div class="mb-3">
                                <span id="invalid-feedback" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addDepartmentButton">Add Department</button>
            </div>
        </div>
    </div>
</div>

<!-- EDIT DEPT MODAL -->
<div class="modal fade" id="EditDept" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="material-symbols-rounded">edit</span>
                <h1 class="modal-title" style="margin-left: 10px;">Edit Department</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="Acronym" class="form-label">Acronym</label>
                            <input type="text" class="form-control" id="editAcronym" placeholder="Enter Department Acronym" required>
                            <div class="mb-3">
                                <span id="acronym-invalid-feedback" class="text-danger"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="mb-3">
                            <label for="Department" class="form-label">Department</label>
                            <input type="text" class="form-control" id="editDepartment" placeholder="Enter Department Name" required>
                            <div class="mb-3">
                                <span id="department-invalid-feedback" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="EditDepartmentButton">Update Department</button>
            </div>
        </div>
    </div>
</div>

<!--REMOVE DEPT MODAL-->

<!-- REMOVE ADMIN MODAL -->
<div class="modal fade" id="RemoveDept" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="material-symbols-rounded">gpp_bad</span>
                <h1 class="modal-title" id="confirmModalLabel">Confirm Removal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3>Are you sure you want to remove Department: <b><span id="deptName"></span></b>?</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmRemoveAdmin()">Yes, Remove</button>
            </div>
        </div>
    </div>
</div>






<!-- JAVASCRIPT -->
<script src="js/script_departments.js"></script>