<?php
//Database Information
$serverName = "localhost";
$dBUserName = "root";
$dBPassword = "";
$dbName = "pacada";

//Database Connection
$conn = mysqli_connect($serverName,$dBUserName,$dBUserName,$dbName);

//Statement to let us know if there are any errors in our connection
if (!$conn){
    die("Connection failed: " . mysqli_connect_error());
}