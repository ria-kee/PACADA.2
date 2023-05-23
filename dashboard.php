<?php include_once "header/active_dashboard.php";?>

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
                                <span class="material-symbols-rounded">analytics</span>
                                <div class="middle">
                                    <div class="left">
                                        <h3>Total Leaves</h3>
                                        <h1>27</h1>
                                    </div>
                                    <div class="progress">
                                        <svg>
                                            <circle cx="38" cy="38" r="36"></circle>
                                        </svg>
                                        <div class="number">
                                            <p>81%</p>
                                        </div>
                                    </div>
                                </div>
                                        <small class="text-muted">May 2023</small>
                                    </div>

                                <!---------------END OF LEAVES--------------->


                                    <!---------------START OF EMPLOYEES--------------->
                                    <div class="Employees">
                                        <span class="material-symbols-rounded">pie_chart</span>
                                        <div class="middle">
                                            <div class="left">
                                                <h3>Employees</h3>
                                                <h1>27</h1>
                                            </div>
                                            <div class="progress">
                                                <svg>
<                                                       !-- ilan sa bawat department-pie-->
                                                    <circle cx="38" cy="38" r="36"></circle>
                                                </svg>
                                                <div class="number">
                                                    <p>81%</p>
                                                </div>
                                            </div>
                                        </div>
                                                <small class="text-muted">May 2023</small>
                                            </div>

                                            <!---------------END OF EMPLOYEES--------------->

                                            <!---------------START OF DEPARTMENTS--------------->
                                            <div class="Departments">
                                                <span class="material-symbols-rounded">analytics</span>
                                                <div class="middle">
                                                    <div class="left">
                                                        <h3>Departments</h3>
                                                        <h1>27</h1>
                                                    </div>
                                                    <div class="progress">
                                                        <svg>
                                                            <circle cx="38" cy="38" r="36"></circle>
                                                        </svg>
                                                        <div class="number">
                                                            <p>81%</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                        <small class="text-muted">May 2023</small>
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
                                                <th>ID</th>
                                                <th>Date</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Juan Dela Cruz</td>
                                                <td>JDC-1203</td>
                                                <td>May 8, 2023</td>
                                                <td class="primary"><a href="#">Details</a></td>
                                            </tr>

                                            <tr>
                                                <td>2</td>
                                                <td>Gregory Del Pilar</td>
                                                <td>GDP-0314</td>
                                                <td>May 8, 2023</td>
                                                <td class="primary"><a href="#">Details</a></td>
                                            </tr>

                                            <tr>
                                                <td>3</td>
                                                <td>Crisostomo Magsalin Ibarra</td>
                                                <td>CMI-1213</td>
                                                <td>May 8, 2023</td>
                                                <td class="primary"><a href="#">Details</a></td>
                                            </tr>

                                            <tr>
                                                <td>4</td>
                                                <td>Maria Clara Alba Delos Santos</td>
                                                <td>MAD-1005</td>
                                                <td>May 8, 2023</td>
                                                <td class="primary"><a href="#">Details</a></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    <a href="#">View All</a>
                                </div>
</div>
                           </main>


                             <!---------------END OF MAIN--------------->

                                <div class="right">
                                <!---------------START OF RECENT UPDATES--------------->
                                <div class="recent-updates">
                                    <h2>Recent Updates</h2>
                                    <div class="updates">

                                        <div class="update">
                                            <div class="profile-photo">
                                                <img src="assets/img/profile-1.jpg">
                                            </div>
                                            <div class="message">
                                                <p><b>Admin1</b> filed leave for employee 3.</p>
                                                <small class="text-muted">2 minutes ago.</small>
                                            </div>
                                        </div>

                                        <div class="update">
                                            <div class="profile-photo">
                                                <img src="assets/img/profile-2.jpg">
                                            </div>
                                            <div class="message">
                                                <p><b>Admin2</b> filed leave for employee 21.</p>
                                                <small class="text-muted">21 minutes ago.</small>
                                            </div>
                                        </div>

                                        <div class="update">
                                            <div class="profile-photo">
                                                <img src="assets/img/profile-2.jpg">
                                            </div>
                                            <div class="message">
                                                <p><b>Admin2</b> filed leave for employee 21.</p>
                                                <small class="text-muted">21 minutes ago.</small>
                                            </div>
                                        </div>


                                        <div class="update">
                                            <div class="profile-photo">
                                                <img src="assets/img/profile-4.jpg">
                                            </div>
                                            <div class="message">
                                                <p><b>Admin3</b> filed leave for employee 3.</p>
                                                <small class="text-muted">39 minutes ago.</small>
                                            </div>
                                        </div>
                                        <div class="update">
                                            <div class="profile-photo">
                                                <img src="assets/img/profile-4.jpg">
                                            </div>
                                            <div class="message">
                                                <p><b>Admin3</b> filed leave for employee 3.</p>
                                                <small class="text-muted">39 minutes ago.</small>
                                            </div>
                                        </div>



                                    </div>
                                    <!---------------END OF RECENT UPDATES--------------->
                                    <!---------------START OF QUICK ACTIONS--------------->
                                    <div class="quick-action">
                                        <h2>Quick Actions</h2>

                                        <a href="#">
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

                                        <a href="#">
                                        <div class="item time-off">
                                            <div class="icon">
                                                <span class="material-symbols-rounded">acute</span>
                                            </div>
                                            <div class="right">
                                                <div class="info">
                                                    <h3>File Time-Off</h3>
                                                    <small class="text-muted">Click to record employee's leave</small>
                                                </div>
                                            </div>
                                        </div>
                                        </a>

                                        <a href="#">
                                        <div class="item add-credits">
                                            <div class="icon">
                                                <span class="material-symbols-rounded">add_card</span>
                                            </div>
                                            <div class="right">
                                                <div class="info">
                                                    <h3>Add Leave Credits</h3>
                                                    <small class="text-muted">Click to record employee's leave</small>
                                                </div>
                                            </div>
                                        </div>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>

                            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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

                    </body>
                </html>
