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
</head>
<body>
<main>
    <div class="box">
        <div class="inner-box">
            <div class="forms-wrap">
                <form action="index.php" autocomplete="off" class="sign-in-form">
                    <div class="logo">
                        <img src="assets/PACADA/PACADA.png" alt="PACADA Logo" />
                        <h3>PACADA</h3>
                    </div>

                    <div class="heading">
                        <h2>Welcome Back!</h2>
                        <h6>Please enter your login details to continue</h6>
                    </div>

                    <div class="actual-form">
                        <div class="input-wrap">
<!--SIGN IN FORM-->
                            <form action ="includes/signin.inc.php" method="post">

                            <input
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
                                type="password"
                                name="password"
                                class="input-field"
                                autocomplete="off"
                                required
                            />
                            <label>Password</label>

                        </div>

                        <button type="submit" name="submit" value="Sign In" class="sign-btn" > Sign In</button>

<!--                        if($_GET["error] =="invalidemail"-->


                </form>
                        <p class="text">
                            Forgotten your password?
                            <a href="#" class="toggle">Get help</a>
                        </p>
                    </div>
                </form>

                <form action="index.php" autocomplete="off" class="sign-up-form">
                    <div class="logo">
                        <img src="assets/PACADA/PACADA.png" alt="PACADA Logo" />
                        <h3>PACADA</h3>
                    </div>

                    <div class="heading">
                        <h2>Forgot Password</h2>
                        <h6>Please enter your email and we'll send a link to reset it. </h6>
                    </div>
<!--FORGOT PASSWORD FORM-->
                    <div class="actual-form">

                        <div class="input-wrap">
                            <input
                                type="email"
                                class="input-field"
                                autocomplete="off"
                                required
                            />
                            <label>Email</label>
                        </div>



                        <input type="submit" value="Send Password Reset Link" class="sign-btn" />

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
                    <img src="assets/img/image3.png" class="image img-3" alt="" />
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
<script src="js/script_index.js"></script>
</body>
</html>
