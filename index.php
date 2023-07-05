<?php
session_start();
if (isset($_SESSION['admin_uID'])) {
// Redirect to the dashboard
    header('Location: dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!--Title Bar Icon-->
    <link rel="icon" href="assets/PACADA/PACADA.png">
    <title>Pacada</title>

    <!--Stylesheet-->
    <link rel="stylesheet" href="css/style_index.css" />
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
                        <h3>PACADA <h3 style="font-weight: lighter; margin-left: 5px"> ADMIN</h3></h3>
                    </div>

                    <div class="heading">
                        <h2>Welcome Back!</h2>
                        <h6>Please enter your login details to continue</h6>
                    </div>
                    <div class="error d-none text-danger" id="error">
                        <span class="material-symbols-rounded" style="font-size: 20px;">error</span> <span>  Wrong Login Credentials</span>
                    </div>


                    <div class="actual-form">
                        <div class="input-wrap">
                            <!--SIGN IN FORM-->
                                <input
                                    id="signIn_email"
                                    name="email"
                                    type="email"
                                    class="input-field"
                                    autocomplete="off"
                                    required
                                />
                                <label>Email</label>
                        </div>

                        <div class="input-wrap">
                            <input
                                id="signIn_password"
                                type="password"
                                name="password"
                                class="input-field"
                                autocomplete="off"
                                required
                            />
                            <label>Password</label>
                        </div>
                        <button type="submit" name="submit" value="Sign In" class="sign-btn" > Sign In</button>
                </form>
                <p class="text">
                    Forgotten your password?
                    <a href="#" class="toggle">Get help</a>
                </p>
            </div>


            <form id="password-reset-form" action="inc.password-reset-link.php" method="post" autocomplete="off" class="sign-up-form">
                <div class="logo">
                    <img src="assets/PACADA/PACADA.png" alt="PACADA Logo" />
                    <h3>PACADA <h3 style="font-weight: lighter; margin-left: 5px"> ADMIN</h3></h3>
                </div>

                <div class="heading">
                    <h2>Forgot Password</h2>
                    <h6>Please enter your email, and we'll send a link to reset it. </h6>
                </div>



                    <div class="error d-none text-danger" id="phpmailer-error" style="flex-direction: column;">
                        <span class="material-symbols-rounded" style="font-size: 30px;">error</span> <br>
                        <span id="phpmailer-error-text"></span>
                    </div>



                <div class="success d-none text-success" id="phpmailer-success">
                    <span class="material-symbols-rounded" style="font-size: 30px;">check_circle</span> <br>
                    <span>Reset Link has been sent.<br>
                        <h6 style="font-size: 10px; font-weight: lighter"> Please check your inbox or spam.</h6></span>
                </div>



                <!--FORGOT PASSWORD FORM-->
                <div class="actual-form">

                    <div class="input-wrap">
                        <input
                            id="reset-email"
                            type="email"
                            name="email"
                            class="input-field"
                            autocomplete="off"
                            required
                        />
                        <label>Email</label>
                    </div>



                    <input type="submit" id="reset-submit" name="password_reset_link" value="Send Password Reset Link" class="sign-btn" />

                    <p class="text">
                        Already settled your account?
                        <a href="#" class="toggle">Sign in</a>
                    </p>

                </div>
            </form>
        </div>

        <div class="carousel">
            <div class="images-wrapper">
                <img src="assets/img/image1.png" class="image img-1 show" alt="Manage Employee Leave Credits" />
                <img src="assets/img/image2.png" class="image img-2" alt="Monitor Employee Leave Records" />
                <img src="assets/img/image3.png" class="image img-3" alt="Track Employee Time-off" />
            </div>

            <div class="text-slider">
                <div class="text-wrap">
                    <div class="text-group">
                        <h2>Manage Employee Leave Credits</h2>
                        <h2>Monitor Employee Leave Records</h2>
                        <h2>Track Employee Time-Off</h2>
                    </div>
                </div>

                <div class="bullets">
                    <span class="active" data-value="1"></span>
                    <span data-value="2"></span>
                    <span data-value="3"></span>
                </div>
            </div>
        </div>
    </div>
    </div>
</main>

<!-- Javascript file -->
<script src="js/script_password-reset-link.js"></script>
<script src="js/script_index.js"></script>
<script src="js/script_login.js"></script>

<?php include('footer/footer.php');?>
</body>
</html>
