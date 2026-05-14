<?php
session_start();
if (session_status() == PHP_SESSION_NONE) {
     session_start();
}

$servername = "localhost";
$username = "projectuser"; 
$password = "StrongPassword123"; 
$dbname = "dva"; 
$port = 3306; // Change if your Workbench uses different port

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$email = $conn->real_escape_string($_POST['mail']);
$password = $_POST['password'];

$sql = "SELECT * FROM patients WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
$row = $result->fetch_assoc();

if (password_verify($password, $row['password'])) {
$_SESSION['patient_id'] = $row['patient_id'];
$_SESSION['patient_name'] = $row['full_name'];

header("Location: patient-dashboard.php");
exit();
} else {
$error = "Incorrect password. Please try again.";
}
} else {
$error = "No user found with that email address.";
}
}

$conn->close();
?>

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

    <link rel="stylesheet" href="./assets/css/login.css" />
</head>

<body>
    <main class="card-container slideUp-animation">
        <div class="image-container">
            <h1 class="company">CD care <sup>&trade;</sup></h1>
            <img src="./assets/images/signUp.svg" class="illustration" alt="" />
            <a class="shift-btn" href="login-doctor.php">Login as a Doctor</a>
            <a href="#btm" class="mobile-btm-nav">
                <img src="./assets/images/dbl-arrow.png" alt="" />
            </a>
        </div>
        <form method="post">
            <div class="form-container slideRight-animation">
                <h1 class="form-header">Log in as patient</h1>

                <div class="input-container">
                    <label for="mail"></label>
                    <input type="email" name="mail" id="mail" required />
                    <span> E-mail </span>
                    <div class="error"></div>
                </div>

                <div class="input-container">
                    <label for="user-password"></label>
                    <input type="password" name="password" id="user-password" class="user-password" required />
                    <span>Password</span>
                    <div class="error"></div>
                </div>

                <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>

                <div id="btm">
                    <button type="submit" class="submit-btn">Log in</button>
                    <p class="btm-text">
                        Don't have an account..?
                        <a class="btm-text-highlighted" href="signup-patient.php" style="cursor: pointer">Sign up</a>
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