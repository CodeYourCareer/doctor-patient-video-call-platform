<?php
session_start(); 

// $servername = "localhost";
// $username = "root"; 
// $password = ""; 
// $dbname = "dva";

// $conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

$servername = "localhost";
$username   = "projectuser";
$password   = "StrongPassword123";
$dbname     = "dva";
$port       = 3306;  // change if Workbench uses another port

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    $sql = "SELECT * FROM doctors WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['doctor_id'] = $row['doctor_id'];
            $_SESSION['doctor_name'] = $row['full_name'];
            $_SESSION['speciality'] = $row['specialty'];

            header("Location: doctors-dashboard.php");
            exit;
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No account found with that email.";
    }
}

$conn->close();
?>