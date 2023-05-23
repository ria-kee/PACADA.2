<?php

if (isset($_POST["submit"])){
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];


    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';


//    ERROR HANDLING


    //If any required fields are empty
    if (admin_emptyInputSignin ($email,$pwd) !==false){
        header("location:../index.php?error=empty_input");
        exit();
    }

    signinUser($conn, $email, $pwd);
}

else{
    header("location:../index.php");
}