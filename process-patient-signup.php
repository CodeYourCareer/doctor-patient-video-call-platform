<?php
session_start();

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
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $age = $conn->real_escape_string($_POST['age']);
    $previous_disease = $conn->real_escape_string($_POST['previous_disease']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $password = $conn->real_escape_string($_POST['password']);

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO patients (full_name, age, previous_disease, email, phone, password)
            VALUES ('$full_name', '$age', '$previous_disease', '$email', '$phone', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        $patient_id = $conn->insert_id;
        $_SESSION['patient_id'] = $patient_id;
        $_SESSION['patient_name'] = $full_name;

        header("Location: login-patient.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>