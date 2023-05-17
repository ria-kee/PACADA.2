<?php

if (isset($_POST["submit"])) {
    $employee_Uid = $_POST["id"];
    $employee_FirstName = $_POST["firstName"];
    $employee_MiddleName = isset($_POST["middleName"]) ? $_POST["middleName"] : "";
    $employee_LastName = $_POST["lastName"];
    $employee_Department = $_POST["department"];
    $employee_AppointmentDate = $_POST["appointment_date"];
    $employee_leaveCreditBalance = isset($_POST["LeaveCreditBalance"]) ? $_POST["LeaveCreditBalance"] : 0.0;
    $employee_Email = $_POST["email"];
    $employee_pw = $_POST["pw"];
    $emp_confirm_pw = $_POST["admin_confirm_pw"];


    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

//If any required fields are empty
    if (employee_emptyInputSignup($employees_Id, $employee_FirstName, $employee_LastName, $employee_Department,$employee_AppointmentDate,$employee_leaveCreditBalance, $employee_Email, $employee_pw, $emp_confirm_pw) !== false) {
        header("location:../addEmployee.php?error=empty_input");
        exit();
    }

//Invalid Uid
    if (employee_invalidUid($employee_Uid) !== false) {
        header("location:../addEmployee.php?error=invalid_id");
        exit();
    }

//Invalid email
    if (employee_invalidEmail($employee_Email) !== false) {
        header("location:../addEmployee.php?error=invalid_email");
        exit();
    }

    //Invalid password
    if (employee_invalidPassword ($employee_pw) !==false){
        header("location:../addAdmin.php?error=invalid_password");
        exit();
    }

//Mismatched Password
    if (employee_passwordMatch($employee_pw, $emp_confirm_pw) !== false) {
        header("location:../addEmployee.php?error=password_mismatch");
        exit();
    }

//Employee Already Exists
    if (employee_Exists($conn, $employee_Uid,$employee_Email) !== false) {
        header("location:../addEmployee.php?error=employee_already_exists");
        exit();
    }
    //create employee
    createEmployee($conn, $employee_Uid,$employee_FirstName,$employee_MiddleName,$employee_LastName,$employee_Department,$employee_AppointmentDate,$employee_leaveCreditBalance,$employee_Email,$employee_pw);
}
else{
    header("location:../employees.php");
}


