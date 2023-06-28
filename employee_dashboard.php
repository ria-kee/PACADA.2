<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['employee_uID'])) {
    // Redirect the user to the login page or show access denied message
    header('Location: error.401-employee.php');
    exit();
}

?>
<!-- HTML content -->

<?php include_once "header_employee/emp.active_leave.php"; ?>

<div class="entire-container">
    <div class="main">
        <div class ="greetings">
            <div class="hello">
                <?php
                date_default_timezone_set('Asia/Manila');
                $currentDate = date('F d, Y');
                $currentTime = date('h:i:s A');
                ?>
                <?php date_default_timezone_set('Asia/Manila'); ?>
                <div class="datetime">
                    <h2 class="date" id="date"><?php echo $currentDate; ?></h2>
                    <h3 class="date" id="time"><?php echo $currentTime; ?></h3>
                </div>
                <h2 id="greeting"> <span id="name"></span>!</h2>
                <h3 id="randomText"></h3>
            </div>
            <div class="greet">
                <img src="assets/svg/emp.svg" alt="">
            </div>
        </div>
        <div class="sub-main">

            <div class="title">
                <h3 style="font-weight: bold">LEAVE BALANCES</h3>
                <span >as of <h2 class="date" id="date" style="color: #1c1f23; font-weight: normal "><?php echo $currentDate; ?></h2></span>
            </div>
            <div class="tablead">
                <div class="table-top">
                </div>
                <table id="leaveBalanceTable" class="table table-striped" style="width:100%">
                    <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>VL</th>
                        <th>SL</th>
                        <th>SPL</th>
                        <th>FL</th>
                    </tr>
                    </thead>

                    <tbody class="table-striped">
                    </tbody>
                </table>

            </div>
            <div class="reminder" style="margin-top: 15px; ">
                <h3 class="reminder-text" style="font-size: 15px; text-align: center;color: #5A5A5A;"> <strong>Reminder:</strong> VL, FL, and SPL shall be filed 5 days in advance of the date of such leave.
                    Except in emergency cases wherein SPL maybe filed immediately upon employee's return
                    from such leave. SL shall be filed immediately upon employee's return from such leave.
                    Application of SL in excess of 5 successive days shall be accompanied by a proper medical certificate.
                    SL maybe applied in advance in cases where employee will undergo medical examination/operation or
                    advised to rest in view of ill health duly supported by a medical certificate. Please indicate what kind
                    of leave you're applying for.</h3>
            </div>
            <hr>
            <div class="title" style="margin-top: 15px">
                <h3 style="font-weight: bold">TIME-OFF BALANCE</h3>
                <span >as of <h2 class="date" id="date" style="color: #1c1f23; font-weight: normal "><?php echo $currentDate; ?></h2></span>
            </div>
            <div class="tablead">
                <div class="table-top">
                </div>
                <table id="timeoffBalanceTable" class="table table-striped" style="width:100%">
                    <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Balance</th>
                    </tr>
                    </thead>

                    <tbody class="table-striped">
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<script>
    var adminFirstName = "<?php echo explode(' ', $_SESSION['employee_FirstName'])[0]; ?>";
</script>

<script src="js_employee/emp.script_dashboard.js"></script>

<script>
    function updateTime() {
        var currentTime = new Date();
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var seconds = currentTime.getSeconds();

        // Add leading zeros to the hours, minutes, and seconds if necessary
        hours = (hours < 10 ? "0" : "") + hours;
        minutes = (minutes < 10 ? "0" : "") + minutes;
        seconds = (seconds < 10 ? "0" : "") + seconds;

        // Determine AM or PM
        var ampm = (hours < 12) ? "AM" : "PM";

        // Convert hours to 12-hour format
        hours = (hours > 12) ? hours - 12 : hours;
        hours = (hours == 0) ? 12 : hours;

        // Update the time display
        document.getElementById('time').innerHTML = hours + ":" + minutes + ":" + seconds + " " + ampm;
    }

    setInterval(updateTime, 1000); // Refresh the time every second
</script>
