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
<link rel="stylesheet" href="css/style_archive_departments.css">

<!--EXPORT-->
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>

<!--<link rel="stylesheet" href="//cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css">-->
<!--<script src="//cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>-->
<!--<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet" />-->
<!--<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>-->


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
        <div class="button-container body-item">
            <div class="grid-item actions">

                <h3>Departments<i class="bi bi-chevron-right"></i><b style="color: var(--color-p3">Archive</b> </h3>
            </div>
            <a href="departments.php">
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
                    <input type="text" class="searchField" placeholder="Search for acronym, department, or etc.">
                </div>
            </div>
        </div>

    </div>
    <div class="tablead">
        <div class="table-top">
            <h3 class="title"><b>ARCHIVED DEPARTMENTS</b></h3>
           <div class="delete">
            <button class="deleteall" data-toggle="modal" data-target="#DeleteAll" id="deleteAllButton" title="No checkbox selected"> <h2><i class="bi bi-trash"></i> </h2></button>
           </div>
        </div>
        <table id="deptTable" class="table table-striped" style="width:100%">
            <thead class="table-dark">
            <th><input class="form-check-input" type="checkbox" value="0" id="selectAllCheckbox"></th>
            <th>Acronym</th>
            <th>Department</th>
            <th class="options">Options</th>
            </thead>
            <tbody class="table-striped">
            </tbody>
        </table>
    </div>
</div>




<!--Delete DEPT MODAL-->
<div class="modal fade" id="DeleteDept" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
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






<!-- JAVASCRIPT -->
<script src="js/script_archivedDept.js"></script>