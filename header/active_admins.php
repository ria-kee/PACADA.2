<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrators</title>
    <link rel="icon" href="../assets/PACADA/PACADA.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <link rel="stylesheet" href="css/style_dashboard.css">
    <link rel="stylesheet" href="css/style_admins.css">
</head>
<body>
<div class="container">
    <div class="header"></div>
    <div class="background"></div>

    <!--END OF ASIDE-->

    <div class="header">
        <h1 class="location">Administrators</h1>
        <div class="profile">
            <div class="info">
                <p>Hello, <b>Jaz!</b></p>
                <small class="text-muted">Super Admin</small>
            </div>
            <div class="profile-photo">
                <img src="./assets/img/no-profile.png" alt="">
            </div>
        </div>
    </div>

    <aside>
    <div class="top">
        <div class="logo">
            <img src="assets/PACADA/PACADA.png" alt="PACADA icon">
            <h2 >PACADA</h2>
        </div>
        <div class="close" id="close-btn">
            <span class="material-symbols-rounded">close</span>
        </div>
    </div>
    <div class="sidebar">
        <a href="dashboard.php">
            <span class="material-symbols-rounded">grid_view</span>
            <h3>Dashboard</h3>
        </a>

        <a href="#">
            <span class="material-symbols-rounded">domain</span>
            <h3>Departments</h3>
        </a>

        <a href="#">
            <span class="material-symbols-rounded">badge</span>
            <h3>Employees</h3>
            <!--                                <span class="material-symbols-rounded">expand_more</span>-->
        </a>

        <a href="#" >
            <span class="material-symbols-rounded">event_upcoming</span>
            <h3>Leave</h3>
        </a>

        <a href="#"  >
            <span class="material-symbols-rounded">work_history</span>
            <h3>Time-Off</h3>
        </a>

        <a href="#" class="active">
            <span class="material-symbols-rounded">manage_accounts</span>
            <h3>Admins</h3>
        </a>
        <a href="#">
            <span class="material-symbols-rounded">person</span>
            <h3>Profile</h3>
        </a>
        <a href="#">
            <span class="material-symbols-rounded">logout</span>
            <h3>Logout</h3>
        </a>
    </div>
</aside>