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
    <title>Sign up | CD care</title>

    <link rel="stylesheet" href="./assets/css/signup.css" />
    <style>
    .input-container .hint {
        display: block;
        font-size: 0.875em;
        color: #666;
        margin-top: 5px;
    }

    .input-container span {
        font-weight: bold;
    }
    </style>
</head>

<body>
    <main class="card-container slideUp-animation">
        <div class="image-container">
            <h1 class="company">CD care <sup>&trade;</sup></h1>
            <img src="./assets/images/signUp.svg" class="illustration" alt="" />
            <a class="shift-btn" href="signup-doctor.php">Sign up as a Doctor</a>
            <a href="#btm" class="mobile-btm-nav">
                <img src="./assets/images/dbl-arrow.png" alt="" />
            </a>
        </div>
        <form action="process-patient-signup.php" method="POST" enctype="multipart/form-data">
            <div class="form-container slideRight-animation">
                <h1 class="form-header">Signup as patient</h1>

                <div class="input-container">
                    <label for="f-name"></label>
                    <input type="text" name="full_name" id="f-name" required />
                    <span> Full Name</span>
                    <div class="error"></div>
                </div>

                <div class="input-container">
                    <label for="age"></label>
                    <input type="number" name="age" id="age" required />
                    <span> Age </span>
                    <div class="error"></div>
                </div>

                <div class="input-container">
                    <label for="previous-disease"></label>
                    <input type="text" name="previous_disease" id="previous-disease" />
                    <span> Previous Disease (Optional) </span>
                    <div class="error"></div>
                </div>

                <div class="input-container">
                    <label for="mail"></label>
                    <input type="email" name="email" id="mail" required />
                    <span> E-mail </span>
                    <div class="error"></div>
                </div>

                <div class="input-container">
                    <label for="phone"></label>
                    <input type="tel" name="phone" id="phone" required />
                    <span>Phone</span>
                    <div class="error"></div>
                </div>

                <div class="input-container">
                    <label for="user-password"></label>
                    <input type="password" name="password" id="user-password" required />
                    <span>Password</span>
                    <div class="error"></div>
                </div>

                <div id="btm">
                    <button type="submit" class="submit-btn">Create Account</button>
                    <p class="btm-text">
                        Already have an account..?
                        <a class="btm-text-highlighted" href="login-patient.php" style="cursor: pointer">
                            Log in now
                        </a>
                    </p>
                </div>
            </div>
        </form>

    </main>
    <section class="outro-overlay disabled slideUp-animation">
        <h1 class="company">CD care <sup>&trade;</sup></h1>
        <h1 class="outro-greeting">Thank's for signing up..!</h1>
        <img src="./assets/images/shape.svg" alt="" class="shape" />
        <img src="./assets/images/signedUp.svg" alt="" id="signedUp-illustration" class="slideRight-animation" />
    </section>
</body>

</html>