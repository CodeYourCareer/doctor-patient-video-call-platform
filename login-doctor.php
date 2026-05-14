<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#06aa5e" />
    <meta name="msapplication-navbutton-color" content="#06aa5e" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <title>Log in | CD care</title>

    <link rel="stylesheet" href="./assets/css/login-doctor.css" />
</head>

<body>
    <main class="card-container slideUp-animation">
        <div class="image-container">
            <h1 class="company">CD care <sup>&trade;</sup></h1>
            <img src="./assets/images/Signup-red.svg" class="illustration" alt="" />
            <a href="login-patient.php" class="shift-btn">Login as a Patient</a>
            <a href="#btm" class="mobile-btm-nav">
                <img src="./assets/images/dbl-arrow.png" alt="" />
            </a>
        </div>
        <form action="process-login-doctor.php" method="POST">
            <div class="form-container slideRight-animation">
                <h1 class="form-header">Log in as Doctor</h1>

                <div class="input-container">
                    <label for="mail"></label>
                    <input type="email" name="email" id="mail" required />
                    <span> E-mail </span>
                    <div class="error"></div>
                </div>

                <div class="input-container">
                    <label for="user-password"></label>
                    <input type="password" name="password" id="user-password" class="user-password" required />
                    <span>Password</span>
                    <div class="error"></div>
                </div>

                <div id="btm">
                    <button type="submit" class="submit-btn">Log in</button>
                    <p class="btm-text">
                        Don't have an account..?
                        <a class="btm-text-highlighted" href="signup-doctor.php" style="cursor: pointer">Sign up</a>
                    </p>
                </div>
            </div>
        </form>

    </main>
    <section class="outro-overlay disabled slideUp-animation">
        <h1 class="company">Cd care <sup>&trade;</sup></h1>
        <h1 class="outro-greeting">Welcome back!</h1>
        <img src="./assets/images/shape.svg" alt="" class="shape" />
        <img src="./assets/images/loggedIn.svg" alt="" id="signedUp-illustration" class="slideRight-animation" />
    </section>
</body>

</html>