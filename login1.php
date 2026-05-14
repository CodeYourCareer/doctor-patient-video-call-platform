<!-- <?php
header("Content-Type: application/json");

// Allow Android app
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Database connection
$conn = new mysqli("localhost", "root", "", "dva");

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "DB Connection Failed"]);
    exit();
}

// Read JSON input
$data = json_decode(file_get_contents("php://input"));

$email = $data->email ?? "";
$password = $data->password ?? "";

if (!$email || !$password) {
    echo json_encode(["success" => false, "message" => "Email & password required"]);
    exit();
}

$sql = "SELECT * FROM patients WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check user exists
if ($result->num_rows == 0) {
    echo json_encode(["success" => false, "message" => "Invalid Email"]);
    exit();
}

$user = $result->fetch_assoc();

// Verify hashed password
if (password_verify($password, $user['password'])) {
    echo json_encode([
        "success" => true,
        "message" => "Login Successful",
        "patient_id" => $user["patient_id"],
        "full_name" => $user["full_name"],
        "email" => $user["email"]
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Wrong Password"]);
}
?> -->