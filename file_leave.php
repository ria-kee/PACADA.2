<?php
session_start();
$allowedPages = ['dashboard.php', 'departments.php', 'employees.php',
    'leave.php', 'timeOff.php', 'admins.php',
    'profile.php', 'archived_employees.php' ,'archived_departments.php','view_logs.php']; // List of allowed pages

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
<link rel="stylesheet" href="css/style_file_leave.css">

<!--EXPORT-->
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>


<?php include_once "header/active_leave.php"; ?>
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

                <h3><a href="leave.php">Leave</a><i class="bi bi-chevron-right"></i><b style="color: var(--color-p3">File Leave</b> </h3>
            </div>
            <a href="leave.php">
                <div class="grid-item button2">
                    <span class="material-symbols-rounded">arrow_back</span>
                    <h3>Go Back</h3>
                </div>
            </a>
        </div>
        <div class="grid-container body-item">
            <div class="grid-item" style=" display: flex; align-items: center; justify-items: center">
                <h3 style=" display: flex;  align-items: center; margin: 0;"> <span class="material-symbols-rounded" style="font-size: 20px;margin-right: 5px; color: var(--color-p1);">domain</span> From what department?</h3>
            </div>
            <div class="grid-item" style=" display: flex; align-items: center; justify-items: center">
                <h3 style=" display: flex;  align-items: center; margin: 0;"> <span class="material-symbols-rounded" style="font-size: 20px;margin-right: 5px; color: var(--color-p1);">badge</span> Which Employee?</h3>
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
            <div class="grid-item">
                <div class="dropdown">
                    <select id="Employee" class="form-select">
                        <option value="0" selected>All</option>
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM departments WHERE is_active=1  ORDER BY dept_uid");

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
        <div class="table-top" style="display: flex; justify-content: center;">
            <h3 style="font-size: 25px; margin-bottom: 15px; text-align: center;"><b class="Datetitle" id="Datetitle"></b></h3>
        </div>

        <div id="leave-container" class="leave-container ">

                <div id="employee-profile" class="leave-item d-none">

                            <div class="employee" style="margin-top: 5rem">
                                <div class="upload">
                                    <div class="upload-placeholder">
                                        <img id="image" src="assets/img/no-profile.png">
                                    </div>
                                </div>
                                <h3 id="selected_emp"style="font-size: 16px; font-weight: bold; margin-top: 2px "></h3>
                            </div>

                    <table id="creditsTable" class="table table-striped" style="min-width: 0; margin-top: 10px">
                        <thead class="table-dark">
                        <tr>
                            <th>Vacation</th>
                            <th>Sick</th>
                            <th>Force</th>
                            <th>SPL</th>
                        </tr>
                        </thead>

                        <tbody class="table-striped">
                        <td id="vacation-value"></td>
                        <td id="sick-value"></td>
                        <td id="force-value"></td>
                        <td id="spl-value"></td>

                        </tbody>
                    </table>




                </div>

            <div id="leave-form" class="leave-item d-none">
                <form>
                    <input class="form-control d-none" id="empUID" type="text">
                    <input class="form-control d-none" id="empDept" type="text">

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="leave-type" class="form-label">Type of Leave</label>
                            <select id="leave-type" class="form-select" style="width: 100%; border-radius: 5px !important;" required>
                                <option value="0" selected disabled>Select Leave Type</option>
                                <option value="Vacation">Vacation</option>
                                <option value="Sick">Sick</option>
                                <option value="Force">Force</option>
                                <option value="Special">Special</option>
                                <option value="Others">Others</option>
                            </select>
                            <span id="invalid-type-feedback" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 mb-3">
                            <label for="leave_date">Date of Leave</label>
                            <input type="date" id="leave_date" class="form-control"  style="height: 40px">
                            <span id="invalid-date-feedback" class="text-danger"></span>
                        </div>
                        <div class="col-md-2 mb-3">
                                <button type="button" id="addDateBtn" class=" form-control button3">
                                    <span class="material-symbols-rounded">calendar_add_on</span>
                                    <h3>Add Date</h3>
                                </button>
                        </div>
                        <div class="form-control dates">
<!--                            <div class="date-container">-->
<!--                                <span  id="leave-date">12/15/2023</span>-->
<!--                                <button type="button" class="btn-close" aria-label="Close"></button>-->
<!--                            </div>-->
                        </div>

                    </div>

                    <div class="row" style="margin-top: 20px">
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <textarea class="form-control" id="remarks" rows="2" maxlength="100"></textarea>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 20px">

                    </div>


                    <button type="button" id="file_submit" class="grid-item button2" >
                        <span class="material-symbols-rounded">event</span>
                        <h3>File Leave</h3>
                    </button>
                    </div>

            </div>


        </div>
    </div>
</div>



<!-- PREVIEW MODAL -->
<div class="modal fade" id="LeavePreview" tabindex="1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="material-symbols-rounded">event</span>
                <h1 class="modal-title" style="margin-left: 10px;">Leave Confirmation</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>



                        <div class="employee">
                            <div class="upload">
                                <div class="upload-placeholder">
                                    <img id="preview_image" src="assets/img/no-profile.png">
                                </div>
                            </div>
                            <h3 id="preview_emp"style="font-size: 16px; font-weight: bold; margin-top: 2px "></h3>
                        </div>


                    <div class="row" style="margin-top: 5px">

                        <div class="col-md-12 mb-3">
                            <label for="preview_type" class="form-label">Leave Type</label>
                            <input type="text" class="form-control" id="preview_type"  readonly>
                        </div>


                        <div class="col-md-12 mb-3">
                            <label for="preview_date" class="form-label">Leave Date(s)</label>
                            <textarea class="form-control" id="preview_date" rows="" readonly></textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="preview_remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" id="preview_remarks" rows="3" readonly></textarea>
                        </div>
                    </div>

                    <div class="row" id="credits-prev">
                        <div class="col-md-5 mb-3">
                            <label for="preview_current" id="whatCredit" class="form-label"></label>
                            <input type="text" class="form-control" id="preview_current"  readonly>
                            <span id="current-invalid-feedback" class="text-danger"></span>
                        </div>

                        <div class="col-md-2 mb-3" style="text-align: center">
                            <span class="material-symbols-rounded" style="margin-top: 28.5px;">trending_flat</span>
                        </div>

                        <div class="col-md-5 mb-3">
                            <label for="preview_updated" id="whatCredit2" class="form-label"></label>
                            <input type="text" class="form-control" id="preview_updated"  readonly>
                        </div>


                    </div>






                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="FileLeaveSubmit">File Leave</button>
            </div>
        </div>
    </div>
</div>

<!-- JAVASCRIPT -->
<script>
    document.body.appendChild(document.getElementById('LeavePreview'));
</script>
<script src="js/script_file_leave.js"></script>