<?php

//For add_admin.inc.php

    //ADMIN: Check if all the required fields are filled out
    function admin_emptyInputSignup($admin_Uid,$admin_FirstName,$admin_LastName,$admin_email,$admin_pw,$admin_confirm_pw){
        $result;
        if (empty($admin_Uid ||$admin_FirstName || $admin_LastName || $admin_email || $admin_pw ||$admin_confirm_pw)){
            $result=true;
        }
        else {
            $result=false;
        }

        return $result;
    };


    //ADMIN: check if uid is valid
    function admin_invalidUid($admin_uid){
        $result;
        if(!preg_match('/^[a-zA-Z]{3}-\d{4}$/',$admin_uid)) {
            $result=true;
        }
        else {
            $result=false;
        }
        return $result;
    }

    //ADMIN: check if email is valid
    function admin_invalidEmail ($admin_email){
        $result;
        if (!filter_var($admin_email, filter_validate_email)) {
            $result=true;
            }
        else{$result=false;
        }
        return $result;
    };

    //ADMIN: check if password is At least 8 characters long
                                //At least one uppercase letter
                                //At least one lowercase letter
                                //At least one number
    function admin_invalidPassword($admin_pw){
        $result;
        if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/',$admin_pw)) {
            $result=true;
        }
        else {
            $result=false;
        }
        return $result;
    }




    //ADMIN: Check if Password and Confirm Password match
    function admin_passwordMatch ($admin_pw, $admin_confirm_pw)
    {
        $result;
        if ($admin_pw !== $confirm_pw) {
            $result = true;
            }
        else{$result = false;
        }
        return $result;
    }
    //If admin already exists
    function adminExists ($conn,$admin_Uid, $admin_email){
    $sql = "SELECT * FROM admins WHERE $admin_Uid=? OR $admin_email=?;";
    //submit sql into db in proper way (statement); initialize new prepared statement to avoid injections
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location:../addAdmin.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss",$admin_Uid, $admin_email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }
    else{
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
    };

    //ADMIN: Create Admin
    function createAdmin($conn, $admin_Uid,$admin_FirstName,$admin_MiddleName,$admin_LastName,$admin_email,$admin_pw){
        $sql = "INSERT INTO admins (adminsUid, adminsFirstName, adminsMiddleName, adminsLastName, adminsEmail, adminsPassword) 
                values (?,?,?,?,?,?);";
        //submit sql into db in proper way (statement); initialize new prepared statement to avoid injections
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("location:../addAdmin.php?error=stmtfailed");
            exit();
        }

        $admin_hashedPwd = password_hash($admin_pw,password_default);

        mysqli_stmt_bind_param($stmt, "ssssss",$admin_Uid,$admin_FirstName,$admin_MiddleName,$admin_LastName,$admin_email,$admin_hashedPwd);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location:../addAdmin.php?error=none");
        exit();
    };




//For add_employee.inc.php

    //EMPLOYEES: Check if all the required fields are filled out
        function employee_emptyInputSignup($employees_Id, $employee_FirstName, $employee_LastName, $employee_Department,$employee_AppointmentDate,$employee_leaveCreditBalance, $employee_Email, $employee_pw, $emp_confirm_pw)  {
        $result;
        if (empty($employees_Id || $employee_FirstName || $employee_LastName || $employee_Department || $employee_AppointmentDate || $employee_leaveCreditBalance || $employee_Email || $employee_pw ||$confirm_pw)){
            $result=true;
        }
        else {
            $result=false;
        }

        return $result;
    };

    //EMPLOYEES:check if uid is valid
    function employee_invalidUid($employee_Uid){
        $result;
        if(!preg_match('/^[a-zA-Z]{2,3}-[0-9]{4}$/',$employee_Uid)) {
            $result=true;
        }
        else {
            $result=false;
        }
        return $result;
    }

    //EMPLOYEES: check if email is valid
    function employee_invalidEmail ($employee_email){
        $result;
        if (!filter_var($employee_email, filter_validate_email)) {
            $result=true;
        }
        else{$result=false;
        }
        return $result;
    };

    //EMPLOYEE: check if password is  At least 8 characters long
                                    //At least one uppercase letter
                                    //At least one lowercase letter
                                    //At least one number
    function employee_invalidPassword($employee_pw){
        $result;
        if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/',$employee_pw)) {
            $result=true;
        }
        else {
            $result=false;
        }
        return $result;
    }

    //EMPLOYEES:Check if Password and Confirm Password match
    function employee_passwordMatch ($employee_pw, $emp_confirm_pw)
    {
        $result;
        if ($emp_pw !== $confirm_pw) {
            $result = true;
        }
        else{$result = false;
        }
        return $result;
    }

    //EMPLOYEES: If employee already exists
    function employee_Exists ($conn,$employee_Uid,$employee_Email){
        $sql = "SELECT * FROM employees WHERE $employee_Uid=? OR $employee_Email=?;";
        //submit sql into db in proper way (statement); initialize new prepared statement to avoid injections
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("location:../addEmployee.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "ss",$employee_Uid, $employee_email);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($resultData)){
            return $row;
        }
        else{
            $result = false;
            return $result;
        }
        mysqli_stmt_close($stmt);
    };


    //Employee: Create Employee
    function createEmployee($conn, $employee_Uid,$employee_FirstName,$employee_MiddleName,$employee_LastName,$employee_Department,$employee_AppointmentDate,$employee_leaveCreditBalance,$employee_Email,$employee_pw){
        $sql = "INSERT INTO employees (employees_uid, employees_FirstName, employees_MiddleName, employees_LastName, employees_Department, employee_appointmentDate, employee_leaveCreditBalance, employees_Email, employees_Password)values (?,?,?,?,?,?,?,?,?);";
        //submit sql into db in proper way (statement); initialize new prepared statement to avoid injections
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("location:../addEmployee.php?error=stmtfailed");
            exit();
        }

        $employee_hashedPwd = password_hash($employee_pw,password_default);

        mysqli_stmt_bind_param($stmt, "sssssssss",$employee_Uid,$employee_FirstName,$employee_MiddleName,$employee_LastName,$employee_Department,$employee_AppointmentDate, $employee_leaveCreditBalance, $employee_Email,$employee_pw);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location:../addEmployee.php?error=none");
        exit();
    };




//    FOR SIGN IN

function admin_emptyInputSignin ($email,$pwd){
    $result;
    if (empty($email || $pwd)){
        $result=true;
    }
    else {
        $result=false;
    }

    return $result;
};

function signinUser($conn, $email, $pwd){
    $adminExists = adminExists($conn,$admin_Uid, $admin_email);

    if($adminExists === false){
        header("location: ../index.php?error=incorrectemail");
    }

    $pwdHashed = $adminExists["adminsPassword"];

    $checkPwd = password_verify($pwd, $pwdHashed);

    if($checkPwd === false) {
        header("location: ../index.php?error=incorrectpassword");
    }
    else if ($checkPwd === true){
        session_start();
        $_SESSION["userid"] = $adminExists["adminsUid"];
        $_SESSION["userid"] = $adminExists["adminsFirstName"];
        header("location: ../dashboard.php");
        exit();
    }
}
