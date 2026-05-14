<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Include DB connection
require_once "connection.php";

// Read JSON input from Android
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode([
        "success" => false,
        "message" => "Empty or Invalid JSON received",
        "raw_input" => file_get_contents("php://input")
    ]);
    exit;
}

$email = trim($data["email"] ?? "");
$password = trim($data["password"] ?? "");


// Fetch user by email
$stmt = $conn->prepare("SELECT patient_id, full_name, email, password FROM patients WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode([
        "success" => false,
        "message" => "User not found"
    ]);
    exit;
}

$user = $result->fetch_assoc();

// Verify hashed password
if (!password_verify($password, $user["password"])) {
    echo json_encode([
        "success" => false,
        "message" => "Incorrect password"
    ]);
    exit;
}

echo json_encode([
    "success" => true,
    "message" => "Login successful",
    "patient_id" => $user["patient_id"],
    "full_name" => $user["full_name"],
    "email" => $user["email"]
]);
?>