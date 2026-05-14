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
    $dob = $conn->real_escape_string($_POST['dob']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $license_number = $conn->real_escape_string($_POST['license_number']);
    $address = $conn->real_escape_string($_POST['address']);
    $password = $conn->real_escape_string($_POST['password']);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $resume = $_FILES['resume'];
    $resume_name = basename($resume['name']);
    $resume_tmp = $resume['tmp_name'];
    $upload_dir = 'uploads/resumes/';
    $resume_path = $upload_dir . $resume_name;

    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if (move_uploaded_file($resume_tmp, $resume_path)) {
        $sql = "INSERT INTO doctors (full_name, dob, email, phone, license_number, address, resume_path, password)
                VALUES ('$full_name', '$dob', '$email', '$phone', '$license_number', '$address', '$resume_path', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            $doctor_id = $conn->insert_id;
            $_SESSION['doctor_id'] = $doctor_id;
            $_SESSION['doctor_name'] = $full_name;

            header("Location: doctors-dashboard.php");
            exit;
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Failed to upload resume.";
    }
}

$conn->close();
?>