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

    <link rel="stylesheet" href="./assets/css/signup-doctor.css" />
</head>

<body>
    <main class="card-container slideUp-animation">
        <div class="image-container">
            <h1 class="company">CD care <sup>&trade;</sup></h1>
            <img src="./assets/images/Signup-red.svg" class="illustration" alt="" />
            <a class="shift-btn" href="signup-patient.php">Sign up as a patient</a>
            <a href="#btm" class="mobile-btm-nav">
                <img src="./assets/images/dbl-arrow.png" alt="" />
            </a>
        </div>
        <form action="process-doctor-signup.php" method="POST" enctype="multipart/form-data">
            <div class="form-container slideRight-animation">
                <h1 class="form-header">Signup as doctor</h1>

                <div class="input-container">
                    <label for="full-name"></label>
                    <input type="text" name="full_name" id="full-name" required />
                    <span> Full Name </span>
                    <div class="error"></div>
                </div>

                <div class="input-container">
                    <label for="dob">Date of Birth</label>
                    <small class="hint">Date of Birth</small>
                    <input type="date" name="dob" id="dob" required />
                    <div class="error"></div>
                </div>

                <div class="input-container">
                    <label for="email"></label>
                    <input type="email" name="email" id="email" required />
                    <span> E-mail </span>
                    <div class="error"></div>
                </div>

                <div class="input-container">
                    <label for="phone"></label>
                    <input type="tel" name="phone" id="phone" required />
                    <span> Phone Number </span>
                    <div class="error"></div>
                </div>

                <div class="input-container">
                    <label for="license-number"></label>
                    <input type="text" name="license_number" id="license-number" required />
                    <span> License Number </span>
                    <div class="error"></div>
                </div>

                <div class="input-container">
                    <label for="address"></label>
                    <input type="text" name="address" id="address" required />
                    <span> Address </span>
                    <div class="error"></div>
                </div>

                <div class="input-container resume-uploader">
                    <label for="resume-uploader"></label>
                    <input type="file" name="resume" id="resume-uploader" accept=".pdf, .doc, .docx" required />
                    <small class="hint">Please upload a PDF document of Resume.</small>
                    <div class="error"></div>
                </div>

                <div class="input-container">
                    <label for="user-password"></label>
                    <input type="password" name="password" id="user-password" class="user-password" required />
                    <span>Password</span>
                    <div class="error"></div>
                </div>

                <div id="btm">
                    <button type="submit" class="submit-btn">Create Account</button>
                    <p class="btm-text">
                        Already have an account..?
                        <a class="btm-text-highlighted" href="login-doctor.php" style="cursor: pointer">Log in</a>
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