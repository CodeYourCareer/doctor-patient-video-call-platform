<?php
session_start(); // Start the session

$conn = new mysqli('localhost', 'root', '', 'dva');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the patient is logged in
if (!isset($_SESSION['patient_id'])) {
    echo "<p>Please log in to book an appointment.</p>";
    exit;
}

// Get logged-in patient details
$patient_id = $_SESSION['patient_id'];
$patient_query = $conn->query("SELECT full_name FROM patients WHERE patient_id = '$patient_id'");
if ($patient_query->num_rows == 0) {
    echo "<p>Patient details not found.</p>";
    exit;
}
$patient = $patient_query->fetch_assoc();

if (!isset($_GET['doctor_id'])) {
    echo "<p>Invalid doctor selected. Please try again.</p>";
    exit;
}

$doctor_id = $_GET['doctor_id'];
$doctor_query = $conn->query("SELECT * FROM doctors WHERE doctor_id = '$doctor_id'");
if ($doctor_query->num_rows == 0) {
    echo "<p>Doctor not found.</p>";
    exit;
}
$doctor = $doctor_query->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $reason = isset($_POST['reason']) ? $conn->real_escape_string($_POST['reason']) : null;

    $insert_query = "INSERT INTO appointments (doctor_id, patient_id, appointment_date, appointment_time, reason)
                     VALUES ('$doctor_id', '$patient_id', '$appointment_date', '$appointment_time', '$reason')";

    if ($conn->query($insert_query) === TRUE) {
        echo "<script>alert('Appointment booked successfully!');</script>";
        echo "<script>window.location.href = 'patient-dashboard.php';</script>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #1d2b3a;
        color: #f8f9fa;
        font-family: Arial, sans-serif;
    }

    .container {
        max-width: 600px;
        margin-top: 50px;
        background-color: #2a2a2a;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    h3 {
        text-align: center;
        margin-bottom: 30px;
        color: #4cae4f;
    }

    label {
        font-weight: bold;
        color: #f8f9fa;
    }

    .form-control {
        margin-bottom: 15px;
        background-color: #3a3a3a;
        color: #f8f9fa;
        border: 1px solid #6c757d;
    }

    .form-control:focus {
        background-color: #3a3a3a;
        color: #f8f9fa;
        border-color: #ffc107;
        box-shadow: none;
    }

    button {
        width: 100%;
        padding: 10px;
        background-color: #ffc107;
        border: none;
        color: #1a1a1a;
        font-size: 16px;
        font-weight: bold;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #e0a800;
    }

    .btn-cancel {
        width: 100%;
        padding: 10px;
        background-color: #dc3545;
        color: #f8f9fa;
        text-align: center;
        display: block;
        text-decoration: none;
        font-size: 16px;
        margin-top: 10px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .btn-cancel:hover {
        background-color: #c82333;
    }

    @media (max-width: 576px) {
        .container {
            margin-top: 30px;
        }

        h3 {
            font-size: 1.5rem;
        }

        .form-control {
            font-size: 14px;
        }
    }
    </style>
</head>

<body>

    <div class="container">
        <h3>Book Appointment with Dr. <?php echo htmlspecialchars($doctor['full_name']); ?></h3>
        <form method="POST" action="">
            <input type="hidden" name="patient_id" value="<?php echo $patient_id; ?>">

            <h1>Patient Name: <?php echo htmlspecialchars($patient['full_name']); ?></h1>

            <label for="appointment_date">Appointment Date:</label>
            <input type="date" name="appointment_date" id="appointment_date" class="form-control" required>

            <label for="appointment_time">Appointment Time:</label>
            <input type="time" name="appointment_time" id="appointment_time" class="form-control" required>

            <label for="reason">Reason for Appointment (Optional):</label>
            <textarea name="reason" id="reason" class="form-control" placeholder="Enter reason"></textarea>

            <button type="submit" name="submit">Book Appointment</button>
            <a href="patient-dashboard.php" class="btn-cancel">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>