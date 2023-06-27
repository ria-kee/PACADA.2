<?php
session_start();
if (!isset($_SESSION['admin_uID'])) {
// Redirect the user to the login page or show access denied message
header('Location: error.401.php');
exit();
}
?>
<!-- jQuery CDN Library -->
<script src="js/bootstrap/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<script src="js/bootstrap/bootstrap.bundle.min.js"></script>

<?php include "header/active_dashboard.php";?>
<?php include('includes/dbh.inc.php');

$action = 'reset SPL credits to';
$what = '3 for a';
$who = 'System';

// Get the affected employees_uid values
$affectedEmployeesQuery = "SELECT employees_uid FROM employees WHERE YEAR(credit_updateDate) <> YEAR(CURRENT_DATE())";
$affectedEmployeesResult = mysqli_query($conn, $affectedEmployeesQuery);

if ($affectedEmployeesResult) {
    while ($row = mysqli_fetch_assoc($affectedEmployeesResult)) {
        $employeeID = $row['employees_uid'];

        $query_log = "INSERT INTO logs (admin_uID, admin_Name, admin_Action, action_what, action_toWhom) VALUES (?, ?, ?, ?, ?)";
        $stmt_log = $conn->prepare($query_log);
        $stmt_log->bind_param("issss", $who, $who, $action, $what, $employeeID);

        if ($stmt_log->execute()) {
            // Log entry added successfully for the current employee
            // Continue with updating the Leave_Special value
            $resetQuery = "UPDATE employees
                           SET Leave_Special = 3, credit_updateDate = NOW()
                           WHERE YEAR(credit_updateDate) <> YEAR(CURRENT_DATE())";
            $resetResult = mysqli_query($conn, $resetQuery);

            if ($resetResult) {
                $response = ['success' => true];
            } else {
                $response = ['success' => false];
                break; // Exit the loop on failure
            }
        } else {
            // Failed to add log entry for the current employee
            $response = ['success' => false];
            break; // Exit the loop on failure
        }

        $stmt_log->close();
    }
} else {
    // No affected employees found
    $response = ['success' => false];
}


$query = "SELECT TIMESTAMPDIFF(YEAR, employees.employees_birthdate, CURDATE()) AS age, count(*) as number FROM employees GROUP BY age";
$result = mysqli_query($conn, $query);


?>

<?php
$query_emp = "SELECT Leave_Type, COUNT(*) as number FROM leaves WHERE MONTH(Leave_Date) = MONTH(CURRENT_DATE()) GROUP BY Leave_Type";
$result_emp = mysqli_query($conn, $query_emp);
?>

<?php
$query_dept = "SELECT employees.employees_Department, COUNT(*) AS employee_count, departments.dept_uid
               FROM employees
               INNER JOIN departments ON employees.employees_Department = departments.uID
               GROUP BY employees.employees_Department";
$result_dept = mysqli_query($conn, $query_dept);

?>




<!--Load the AJAX API-->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart()
    {
        var data = google.visualization.arrayToDataTable([
            ['Gender', 'Number'],
            <?php
            while($row = mysqli_fetch_array($result))
            {
                echo "['".$row["age"]."', ".$row["number"]."],";
            }
            ?>
        ]);

        var options = {
            'backgroundColor': 'transparent',
            'legend': 'none',
            chartArea: {
                height: '100%',
                width: '100%',
                left: 5,
            },
            'width':120,
            'height':120,
            pieHole: 0.4
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_employees'));
        chart.draw(data, options);
    }
</script>

<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart()
    {
        var data = google.visualization.arrayToDataTable([
            ['Leave_Type', 'Number'],
            <?php
            while($row = mysqli_fetch_array($result_emp))
            {
                echo "['".$row["Leave_Type"]."', ".$row["number"]."],";
            }
            ?>
        ]);

        var options = {
            'backgroundColor': 'transparent',
            'legend': 'none',
            chartArea: {
                height: '100%',
                width: '100%',
                left: 5,
            },
            'width':120,
            'height':120,
            pieHole: 0.4
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_leaves'));
        chart.draw(data, options);
    }
</script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart()
    {
        var data = google.visualization.arrayToDataTable([
            ['Department', 'Number'],
            <?php
            while($row = mysqli_fetch_array($result_dept))
            {
                echo "['".$row["dept_uid"]."', ".$row["employee_count"]."],";
            }
            ?>
        ]);

        var options = {
            'backgroundColor': 'transparent',
            'legend': 'none',
            chartArea: {
                height: '100%',
                width: '100%',
                left: 5,
            },
            'width':120,
            'height':120,
            pieHole: 0.4
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_dept'));
        chart.draw(data, options);
    }
</script>

<!--MAIN-->

<main>
<div class="scrollable-content">
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
                                <img src="assets/svg/greetings.svg" alt="">
                            </div>
                        </div>

                    <div class="insights">
                        <!---------------START OF LEAVES--------------->
                            <div class="Leaves">
                                <span class="material-symbols-rounded">event</span>
                                <div class="middle">
                                    <div class="left">
                                        <h3>Total Monthly Leaves</h3>
                                    </div>
                                    <div id="chart_leaves"></div>
                                </div>
                                <small class="text-muted">
                                    <?php
                                    date_default_timezone_set('Asia/Manila');
                                    echo date('F Y');
                                    ?>
                                </small>
                                    </div>

                                <!---------------END OF LEAVES--------------->


                                    <!---------------START OF EMPLOYEES--------------->
                                    <div class="Employees">
                                        <span class="material-symbols-rounded">pie_chart</span>
                                        <div class="middle">
                                            <div class="left">
                                                <h3>Age of Employees</h3>
                                            </div>
                                            <div id="chart_employees"></div>
                                        </div>
                                                <small class="text-muted">  <?php
                                                    date_default_timezone_set('Asia/Manila');
                                                    echo date('F Y');
                                                    ?></small>
                                            </div>

                                            <!---------------END OF EMPLOYEES--------------->

                                            <!---------------START OF DEPARTMENTS--------------->
                                            <div class="Departments">
                                                <span class="material-symbols-rounded">analytics</span>
                                                <div class="middle">
                                                    <div class="left">
                                                        <h3>Departments</h3>
                                                    </div>
                                                    <div id="chart_dept"></div>
                                                </div>
                                                        <small class="text-muted">  <?php
                                                            date_default_timezone_set('Asia/Manila');
                                                            echo date('F Y');
                                                            ?></small>
                                                    </div>
                                                 <!---------------END OF DEPARTMENTS--------------->
                                </div>
                                                <!---------------END OF INSIGHTS--------------->

    <div class="recent-leaves">
        <h2>Recent Leaves</h2>
        <table>
            <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Leave</th>
                <th>Date</th>
                <th>Filed by</th>
            </tr>
            </thead>
            <tbody style="font-size: 14px">
            <?php


            // SQL query to retrieve leave data
            $query_leaves = "SELECT l.*, e.employees_FirstName, e.employees_MiddleName, e.employees_LastName
                             FROM leaves l
                             INNER JOIN employees e ON l.Employee_ID = e.uID
                             ORDER BY l.Leave_Date DESC
                             LIMIT 4";
            $result_leaves = mysqli_query($conn, $query_leaves);

            // Check if there are any rows returned
            if (mysqli_num_rows($result_leaves) > 0) {
                $counter = 1; // Initialize a counter variable

                // Iterate through each row
                while ($row = mysqli_fetch_assoc($result_leaves)) {
                    $empName = ucwords(strtolower($row['employees_FirstName'])) . ' ';

                    if (!empty($row['employees_MiddleName'])) {
                        $empName .= strtoupper(substr($row['employees_MiddleName'], 0, 1)) . '. ';
                    }

                    $empName .= ucwords(strtolower($row['employees_LastName']));
                    $leaveCode = $row['Leave_Type'];
                    $date = $row['Leave_Date'];
                    $filed = $row['filed_by'];

                    // Output the table row with leave data
                    echo "<tr>";
                    echo "<td>$counter</td>";
                    echo "<td>$empName</td>";
                    echo "<td>$leaveCode</td>";
                    echo "<td>$date</td>";
                    echo "<td>$filed</td>";
                    echo "</tr>";

                    $counter++; // Increment the counter
                }
            } else {
                // No leaves found
                echo "<tr><td colspan='5'>No recent leaves found.</td></tr>";
            }

            ?>
            </tbody>
        </table>
        <a href="leave.php">View All</a>
    </div>

</div>
                           </main>


                             <!---------------END OF MAIN--------------->

                                <div class="right" style="z-index: -5">
                                <!---------------START OF RECENT UPDATES--------------->
                                    <?php
                                    // Assuming you have established a MySQL database connection

                                    // Retrieve the updates from the logs table ordered by createdAt
                                    $query = "SELECT * FROM logs ORDER BY createdAt DESC LIMIT 5";
                                    $result = mysqli_query($conn, $query);

                                    // Generate the HTML markup for the updates
                                    $html = '<div class="recent-updates">
            <h2>Recent Updates</h2>
            <div class="updates">';

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        // Calculate the relative time from the createdAt field
                                        $createdAt = strtotime($row['createdAt']);
                                        $currentTime = time();
                                        $timeDiff = $currentTime - $createdAt;
                                        $relativeTime = '';

                                        // Retrieve the longblob image from the session variable
                                        $encodedValue =$_SESSION['admin_Profile'];

                                        // Generate the HTML markup for each update
                                        $html .= '<div class="update">
                <div class="profile-photo">
                    <img src="data:image/jpeg;base64,' . $encodedValue . '" alt="Longblob Image">
                </div>
                <div class="message">
                    <p><b>' . $row['admin_Name'] . '</b>'.' '.  $row['admin_Action'].' '.  $row['action_what']  .' '.  $row['action_toWhom'] .'.</p>
                    <small id="recentupdates" class="text-muted relative" data-createdAt="' . strtotime($row['createdAt']) . '"></small>
                </div>
            </div>';
                                    }

                                    $html .= '</div></div>';
                                    ?>

                                    <!-- Output the generated HTML markup -->
                                    <?php echo $html; ?>

                                    <!---------------END OF RECENT UPDATES--------------->
                                    <!---------------START OF QUICK ACTIONS--------------->
                                    <div class="quick-action">
                                        <h2>Quick Actions</h2>

                                        <a href="file_leave.php">
                                        <div class="item file-leave">
                                            <div class="icon">
                                                <span class="material-symbols-rounded">event</span>
                                            </div>
                                            <div class="right">
                                                <div class="info">
                                                    <h3>File Leave</h3>
                                                    <small class="text-muted">Click to record employee's leave</small>
                                                </div>
                                            </div>
                                        </div>
                                        </a>

                                        <a href="timeOff.php">
                                        <div class="item time-off">
                                            <div class="icon">
                                                <span class="material-symbols-rounded">acute</span>
                                            </div>
                                            <div class="right">
                                                <div class="info">
                                                    <h3>File Time-Off</h3>
                                                    <small class="text-muted">Click to record employee's time-off</small>
                                                </div>
                                            </div>
                                        </div>
                                        </a>

                                        <a href="credits.php">
                                        <div class="item add-credits">
                                            <div class="icon">
                                                <span class="material-symbols-rounded">avg_pace</span>
                                            </div>
                                            <div class="right">
                                                <div class="info">
                                                    <h3>Record Late</h3>
                                                    <small class="text-muted">Click here to record monthly late attendance of employees</small>
                                                </div>
                                            </div>
                                        </div>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>



<script>
    var adminFirstName = "<?php echo explode(' ', $_SESSION['admin_FirstName'])[0]; ?>";
</script>


                            <script src="js/script_dashboard.js"></script>


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

<script>
    // Function to update relative time for all elements with the 'text-muted' class
    function updateRelativeTime() {
        var elements = document.getElementsByClassName('relative');
        var currentTime = Math.floor(Date.now() / 1000); // Get current time in seconds

        for (var i = 0; i < elements.length; i++) {
            var createdAt = parseInt(elements[i].getAttribute('data-createdAt'));
            var timeDiff = currentTime - createdAt;
            var relativeTime = '';

            if (timeDiff < 60) {
                relativeTime = timeDiff + ' seconds ago';
            } else if (timeDiff < 3600) {
                relativeTime = Math.floor(timeDiff / 60) + ' minutes ago';
            } else if (timeDiff < 86400) {
                relativeTime = Math.floor(timeDiff / 3600) + ' hours ago';
            } else {
                relativeTime = Math.floor(timeDiff / 86400) + ' days ago';
            }

            elements[i].textContent = relativeTime;
        }
    }

    // Initial update of relative time
    updateRelativeTime();

    // Update relative time every second (adjust the interval as needed)
    setInterval(updateRelativeTime, 1000);

</script>


