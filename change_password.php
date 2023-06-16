<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!--Title Bar Icon-->
    <link rel="icon" href="assets/PACADA/PACADA.png">
    <title>Reset Password</title>

    <!--Stylesheet-->
    <link rel="stylesheet" href="css/style_change_password.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">

    <!-- jQuery CDN Library -->
    <script src="js/bootstrap/jquery-3.6.0.min.js"></script>

</head>
<body>
<main>
    <div class="box">
        <div class="inner-box">
            <div class="forms-wrap">
                <form autocomplete="off" class="sign-in-form" action="login.php" method="POST" id="loginForm">
                    <div class="logo">
                        <img src="assets/PACADA/PACADA.png" alt="PACADA Logo" />
                        <h3>PACADA</h3>
                    </div>

                    <div class="heading">
                        <h2>Reset Password</h2>
                        <h6>for example@gmail.com</h6>
                    </div>
                    <div class="success d-none text-success" id="change-success">
                        <span class="material-symbols-rounded" style="font-size: 30px;">check_circle</span> <br>
                        <span>Your password has been changed successfully.<br>
                    </div>

                    <div class="error d-none text-danger" id="change-error" style="flex-direction: column;">
                        <span class="material-symbols-rounded" style="font-size: 30px;">error</span> <br>
                        <span>Passwords don't match.</span>
                    </div>

                    <div class="actual-form">
                        <div class="input-wrap">
                            <!--SIGN IN FORM-->
                            <input
                                id="new_password"
                                name="new_password"
                                type="password"
                                class="input-field"
                                autocomplete="off"
                                required
                            />
                            <label>Password</label>
                        </div>

                        <div class="input-wrap">
                            <input
                                id="new_confirm_password"
                                type="password"
                                name="password"
                                class="input-field"
                                autocomplete="off"
                                required
                            />
                            <label>Confirm Password</label>
                        </div>
                        <button type="submit" name="submit" value="Sign In" class="sign-btn" > Update Password</button>
                </form>
                <p class="text">
                    Already settled your account?
                    <a href="index.php" class="toggle">Login</a>
                </p>
            </div>

        </div>

        <div class="carousel">
            <img class="error_image" src="assets/img/Reset-password.png" alt="Error Image">

        </div>
    </div>
    </div>
</main>
<!-- Javascript file -->
<script src="js/script_index.js"></script>
<script src="js/script_login.js"></script>

</body>
</html>
