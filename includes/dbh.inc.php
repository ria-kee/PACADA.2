<?php

//Database Information
$hostname = "127.0.0.1";
$username = "root";
$password = "";
$database = "pacada";


//Database Connection
$conn = mysqli_connect($hostname,$username,$password,$database);

//Statement to let us know if there are any errors in our connection
if (!$conn){
    die("Connection failed: " . mysqli_connect_error());
}