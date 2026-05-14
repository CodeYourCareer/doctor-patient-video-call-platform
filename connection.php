<?php
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
?>