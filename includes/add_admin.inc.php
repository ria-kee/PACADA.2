<?php


 if (isset($_POST["submit"])){
     $admin_Uid = $_POST["ID"];
     $admin_FirstName = $_POST["firstName"];
     $admin_MiddleName = isset($_POST["middleName"]) ? $_POST["middleName"] : "";
     $admin_LastName = $_POST["lastName"];
     $admin_email = $_POST["email"];
     $admin_pw = $_POST["pw"];
     $admin_confirm_pw = $_POST["admin_confirm_pw"];

     require_once 'dbh.inc.php';
     require_once 'functions.inc.php';

     //If any required fields are empty
     if (admin_emptyInputSignup ($admin_FirstName,$admin_LastName,$admin_Uid,$admin_email,$admin_pw,$admin_confirm_pw) !==false){
         header("location:../addAdmin.php?error=empty_input");
         exit();
     }

     //Invalid Uid
     if(admin_invalidUid($admin_Uid)!==false){
         header("location:../addAdmin.php?error=invalid_id");
         exit();
     }

     //Invalid email
     if (admin_invalidEmail ($admin_email) !==false){
         header("location:../addAdmin.php?error=invalid_email");
         exit();
     }

     //Invalid password
     if (admin_invalidPassword ($admin_pw) !==false){
         header("location:../addAdmin.php?error=invalid_password");
         exit();
     }

     //Mismatched Password
     if (admin_passwordMatch ($admin_pw, $admin_confirm_pw) !==false){
         header("location:../addAdmin.php?error=password_mismatch");
         exit();
     }

     //Admin Already Exists
     if (adminExists ($conn,$admin_Uid,$admin_email) !==false){
         header("location:../addAdmin.php?error=user_already_exists");
         exit();
     }
    //create Admin acc
     createAdmin($conn, $admin_Uid,$admin_FirstName,$admin_MiddleName,$admin_LastName,$admin_email,$admin_pw);

 }
 else{
     header("location:../index.php");
 }
