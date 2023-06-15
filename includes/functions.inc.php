<?php

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



function signinUser($conn, $email, $pwd, $admin){
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
