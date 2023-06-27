
<?php
session_start();
$allowedPages = ['dashboard.php', 'departments.php', 'employees.php',
    'leave.php', 'admins.php',
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
<link rel="stylesheet" href="css/style_timeOff.css">

<!--EXPORT-->
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>


<?php include_once "header/active_time-off.php"; ?>
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

    </div>
    <div class="tablead">
        <div class="table-top">
            <h3><b>TIME-OFF</b></h3>
        </div>
        <table id="timeTable" class="table table-striped" style="width:100%">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Department</th>
                <th>Name</th>
                <th>Time-Off Balance</th>
                <th>Remarks</th>
                <th>Options</th>
            </tr>
            </thead>

            <tbody class="table-striped">
            </tbody>
        </table>

    </div>
</div>



<!--EDIT REMARKS MODAL-->
<div class="modal fade" id="RemarksModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="material-symbols-rounded">description</span>
                <h1 class="modal-title" id="confirmModalLabel">Edit Remarks</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="employee">
                        <div class="upload">
                            <div class="upload-placeholder">
                                <img id="preview-image"/>
                            </div>
                        </div>
                        <h3 id="preview_emp"style="font-size: 16px; font-weight: bold; margin-top: 2px "></h3>
                        <h3 id="preview-id" style="font-weight: unset"></h3>
                        <h4 id="preview-dept" style="font-weight: lighter"></h4>
                    </div>

                    <div class="form-group" style="margin-top: 10px">
                        <div class="mb-3">
                            <label for="Department" class="form-label">Remarks</label>
                            <textarea class="form-control" maxlength="150" id="remarks" name="remarks" rows="3" cols="50"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="saveRemarks" class="btn btn-primary" onclick="">Save Remarks</button>
            </div>
        </div>
    </div>
</div>


<!--ADD TIME-OFF MODAL-->
<div class="modal fade" id="AddTimeOffModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="material-symbols-rounded">acute</span>
                <h1 class="modal-title" id="confirmModalLabel">Add Time-Off Credits</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="employee">
                        <div class="upload">
                            <div class="upload-placeholder">
                                <img id="credit_image"/>
                            </div>
                        </div>
                        <h3 id="credit_emp"style="font-size: 16px; font-weight: bold; margin-top: 2px "></h3>
                        <h3 id="credit_id" style="font-weight: unset"></h3>
                        <h4 id="credit_dept" style="font-weight: lighter"></h4>
                    </div>

                    <div class="form-group" style="margin-top: 10px">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="Hours" class="form-label">Hours</label>
                                <input class="form-control" id="Hours" type="number" min="0" max="23" step="1" placeholder="00">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="Minutes" class="form-label">Minutes</label>
                                <input class="form-control" id="Minutes" type="number" min="0" max="59" step="1" placeholder="00" >
                            </div>
                            <span id="hours-invalid-feedback" class="text-danger"></span>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="addCredit" class="btn btn-primary">Add Time-Off Credits</button>
            </div>
        </div>
    </div>
</div>



<!--CLAIM TIME-OFF MODAL-->
<div class="modal fade" id="ClaimTimeOffModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="material-symbols-rounded">timer</span>
                <h1 class="modal-title" id="confirmModalLabel">Claim Time-Off Credits</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="employee">
                        <div class="upload">
                            <div class="upload-placeholder">
                                <img id="claim_image"/>
                            </div>
                        </div>
                        <h3 id="claim_emp"style="font-size: 16px; font-weight: bold; margin-top: 2px "></h3>
                        <h3 id="claim_id" style="font-weight: unset"></h3>
                        <h4 id="claim_dept" style="font-weight: lighter"></h4>
                    </div>

                    <div class="form-group" style="margin-top: 10px">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="claim_Hours" class="form-label">Hours</label>
                                <input class="form-control" id="claim_Hours" type="number" min="0" max="23" step="1" placeholder="00">

                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="claim_Minutes" class="form-label">Minutes</label>
                                <input class="form-control" id="claim_Minutes" type="number" min="0" max="59" step="1" placeholder="00" >
                            </div>
                            <span id="claim-hr-invalid-feedback" class="text-danger"></span>
                        </div>

                        <div class="form-group" style="margin-top: 10px">
                            <div class="mb-3">
                                <label for="claim_remarks" class="form-label">Remarks</label>
                                <textarea class="form-control" maxlength="150" id="claim_remarks" name="claim_remarks" rows="3" cols="50"></textarea>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="useCredit" class="btn btn-primary">Claim Time-Off Credits</button>
            </div>
        </div>
    </div>
</div>


<!-- JAVASCRIPT -->
<script>
    document.body.appendChild(document.getElementById('RemarksModal'));
    document.body.appendChild(document.getElementById('AddTimeOffModal'));
    document.body.appendChild(document.getElementById('ClaimTimeOffModal'));

</script>
<script src="js/script_timeOff.js"></script>
