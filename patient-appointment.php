<?php
session_start();

if (!isset($_SESSION['patient_id'])) {
    header("Location: login-patient.php");
    exit;
}

include 'connection.php';

$patient_id = $_SESSION['patient_id'];
$patient_name = $_SESSION['patient_name'];

$approvedAppointments = $conn->query("
    SELECT a.*, d.full_name AS doctor_name, d.specialty 
    FROM appointments a
    JOIN doctors d ON a.doctor_id = d.doctor_id
    WHERE a.patient_id = $patient_id AND a.status = 'approved'
");

$historyAppointments = $conn->query("
    SELECT a.*, d.full_name AS doctor_name, d.specialty 
    FROM appointments a
    JOIN doctors d ON a.doctor_id = d.doctor_id
    WHERE a.patient_id = $patient_id AND a.status = 'consulted'
");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://meet.jit.si/external_api.js"></script>
    <style>
    body {
        background-color: #1d2b3a;
        color: #ffffff;
        font-family: Arial, sans-serif;

    }

    h4 {
        color: #4cae4f;
    }

    .navbar {
        background-color: #000000;
        height: 70px;
    }

    .navbar .nav-link {
        color: #ffffff;
    }

    .card {
        background-color: #1c1c1c;
        color: #ffffff;
        border: 1px solid #333333;
    }

    .card h5,
    .card p {
        margin: 0;
    }

    .card .btn-primary {
        background-color: #0066cc;
        border: none;
    }

    #video-call-container {
        display: none;
        height: 500px;
        width: 100%;
        border: 1px solid #ddd;
        margin-top: 20px;
    }

    .text-warning {
        color: #4cae4f !important;
    }

    footer {
        margin-bottom: 0;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">CD Care <sup>&trade;</sup></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="patient-dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="patient-appointment.php">Appointments</a></li>
                    <li class="nav-item"><a class="nav-link" href="p-logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Appointments</h2>

        <div class="mb-4">
            <h4>Approved Appointments</h4>
            <?php if ($approvedAppointments->num_rows > 0): ?>
            <div class="row">
                <?php while ($row = $approvedAppointments->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="card p-3 mb-3">
                        <h5>Dr. <?php echo htmlspecialchars($row['doctor_name']); ?></h5>
                        <p>Specialty: <?php echo htmlspecialchars($row['specialty']); ?></p>
                        <p>Date: <?php echo htmlspecialchars($row['appointment_date']); ?></p>
                        <p>Time: <?php echo htmlspecialchars($row['appointment_time']); ?></p>
                        <button class="btn btn-primary join-call"
                            data-room="<?php echo htmlspecialchars('room-' . $row['appointment_id']); ?>"
                            data-appointment-id="<?php echo $row['appointment_id']; ?>">
                            Join Video Call
                        </button>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            <?php else: ?>
            <p>No approved appointments found.</p>
            <?php endif; ?>
        </div>

        <div>
            <h4>Consultation History</h4>
            <?php if ($historyAppointments->num_rows > 0): ?>
            <div class="row">
                <?php while ($row = $historyAppointments->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="card p-3 mb-3">
                        <h5>Dr. <?php echo htmlspecialchars($row['doctor_name']); ?></h5>
                        <p>Specialty: <?php echo htmlspecialchars($row['specialty']); ?></p>
                        <p>Date: <?php echo htmlspecialchars($row['appointment_date']); ?></p>
                        <p>Time: <?php echo htmlspecialchars($row['appointment_time']); ?></p>
                        <p>Status: Consulted</p>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            <?php else: ?>
            <p>No consultation history found.</p>
            <?php endif; ?>
        </div>

        <div id="video-call-container"></div>
    </div>

    <footer class="bg-dark text-light py-4" style="margin-top:100px;">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6">
                    <h5 class="text-warning">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none">About Us</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Contact Us</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Blogs</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Video-consultation</a></li>
                    </ul>
                </div>

                <div class="col-md-3 col-6">
                    <h5 class="text-warning">Support</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none">Home</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Services</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Our Team</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Testimonials</a></li>
                    </ul>
                </div>

                <div class="col-md-3 col-6">
                    <h5 class="text-warning">Contact Detail</h5>
                    <ul class="list-unstyled">
                        <li>Phone: 8303674267</li>
                        <li>
                            Email:
                            <a href="mailto:ayurconnect@gmail.com" class="text-light text-decoration-none"
                                style="flex-wrap:wrap-content;">codingdecode@gmail.com</a>
                        </li>
                        <li>Follow Us:</li>
                    </ul>
                </div>

                <div class="col-md-3 col-6">
                    <h5 class="text-warning">Registered Address</h5>
                    <ul class="list-unstyled">
                        <li>VGI Hostel</li>
                        <li>Gautam Buddha Nagar-201314, Uttar Pradesh, India</li>
                        <li>Corporate Office:</li>
                        <li>VGI Hostel</li>
                        <li>Gautam Buddha Nagar-201314, Uttar Pradesh, India</li>
                    </ul>
                </div>
            </div>

            <div class="text-center mt-3">
                <p class="mb-0">&copy; 2024 CD Care <sup>&trade;</sup>. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.join-call').forEach(button => {
            button.addEventListener('click', function() {
                const roomName = this.getAttribute('data-room');
                const appointmentId = this.getAttribute('data-appointment-id');
                const videoCallContainer = document.getElementById('video-call-container');
                const domain = "meet.jit.si";

                videoCallContainer.style.display = "block";

                videoCallContainer.innerHTML = "";

                const options = {
                    roomName: roomName,
                    width: "100%",
                    height: 500,
                    parentNode: videoCallContainer,
                    userInfo: {
                        displayName: "<?php echo htmlspecialchars($patient_name); ?>"
                    }
                };

                const api = new JitsiMeetExternalAPI(domain, options);

                api.addEventListener('readyToClose', () => {
                    fetch('update-status.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            appointmentId: appointmentId
                        })
                    }).then(() => {
                        location.reload();
                    });
                });
            });
        });
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>