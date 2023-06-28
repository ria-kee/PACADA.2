<?php
session_start();
$allowedPages = ['employee_dashboard.php', 'employee_profile.php', 'employee_timeoff.php']; // List of allowed pages

$currentFile = basename($_SERVER['PHP_SELF']); // Get the name of the current PHP file

// Check if the user is not logged in and the current page is not in the allowed pages list
if (!isset($_SESSION['employee_uID']) && !in_array($currentFile, $allowedPages)) {
    // Redirect the user to the login page or show access denied message
    header('Location: error.401-employee.php');
    exit();
}
?>

<?php include_once "header_employee/emp.active_history.php"; ?>

<div class="entire-container" >
    <div class="main" >
        <div class="tab">
            <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist" style="margin: unset">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Leave</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Timeoff</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent" style="background-color: #fff;  border-radius: 0px 0px 10px 10px; height: 95%; padding: 10px;">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" >
                    <div class="table-bg">
                        <div class="tablead">
                            <div class="table-top">
                            </div>
                            <table id="leaveTable" class="table table-striped" style="width:100%">
                                <thead class="table-dark">
                                <tr>
                                    <th>Leave Date</th>
                                    <th>Leave Type</th>
                                    <th>Filed By</th>
                                    <th>Filed At</th>
                                </tr>
                                </thead>

                                <tbody class="table-striped">
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="table-bg">
                        <div class="tablead">
                            <div class="table-top">
                            </div>
                            <table id="timeTable" class="table table-striped" style="width:100%">
                                <thead class="table-dark">
                                <tr>
                                    <th>Claimed Time-off</th>
                                    <th>Filed By</th>
                                    <th>Filed At</th>
                                </tr>
                                </thead>

                                <tbody class="table-striped">
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

</div>

<script src="js_employee/emp.script_history.js"></script>