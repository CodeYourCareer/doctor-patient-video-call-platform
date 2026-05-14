<?php
session_start(); 

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login-doctor.php");
    exit;
}

include 'connection.php';

$doctor_id = $_SESSION['doctor_id'];
$doctor_name = $_SESSION['doctor_name'];

$sql = "SELECT doctor_id, full_name, specialty, experience, degree, hospital_name, dob, email, phone, address FROM doctors WHERE doctor_id = ?";
$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $doctor_id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $doctor = $result->fetch_assoc(); 
    $doctor_name = $doctor['full_name'];
    $specialty = $doctor['specialty'];
    $degree = $doctor['degree']; 
    $experience = $doctor['experience'];
    $hospital_name = $doctor['hospital_name'];
    $dob = $doctor['dob'];
    $email = $doctor['email'];
    $phone = $doctor['phone'];
    $address = $doctor['address'];
} else {
    echo "Doctor not found.";
    exit;
}

$stmt->close();

$requestedAppointments = $conn->query("SELECT a.*, p.full_name AS patient_name, p.age 
    FROM appointments a 
    JOIN patients p ON a.patient_id = p.patient_id 
    WHERE a.doctor_id = $doctor_id AND a.status = 'pending'");

$approvedAppointments = $conn->query("SELECT a.*, p.full_name AS patient_name 
    FROM appointments a 
    JOIN patients p ON a.patient_id = p.patient_id 
    WHERE a.doctor_id = $doctor_id AND a.status = 'approved'");

$patientHistory = $conn->query("SELECT a.*, p.full_name AS patient_name 
    FROM appointments a 
    JOIN patients p ON a.patient_id = p.patient_id 
    WHERE a.doctor_id = $doctor_id AND a.status IN ('approved', 'rescheduled')");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/doctors-dashboard.css">
    <style>
    .text-warning {
        color: #4cae4f !important;
    }

    .custom-navbar {
        height: calc(56px + 15px);
    }

    .custom-navbar .navbar-brand,
    .custom-navbar .nav-link {
        line-height: calc(56px + 15px);
    }

    .navbar-brand {
        margin-left: 15px;
        font-size: 20px;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-dark text-white custom-navbar" style=">
  <div class=" container-fluid">
        <a class="navbar-brand text-white" href="#">CD care <sup>&trade;</sup></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active text-white" aria-current="page" href="patient-dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Appointments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Contacts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="p-logout.php">Logout</a>
                </li>
            </ul>
        </div>
        </div>
    </nav>

    <div class="container-fluid custom-container">
        <div class="row mt-3">
            <div class="col-md-3">
                <div class="profile-card" style="text-align:left;">
                    <img src="uploads/profile/abc.png" alt="Doctor" class="rounded-circle mb-3"
                        style="height:100px;margin-left:30%;">
                    <h4>Dr. <?php echo htmlspecialchars($doctor_name); ?></h4>
                    <p>Specialty: <?php echo htmlspecialchars($specialty); ?></p>
                    <p>Degree: <?php echo htmlspecialchars($degree); ?></p>
                    <p>Experience: <?php echo htmlspecialchars($experience); ?></p>
                    <p>Hospital Name: <?php echo htmlspecialchars($hospital_name); ?></p>
                    <p>Date of Birth: <?php echo htmlspecialchars($dob); ?></p>
                    <p>Phone: <?php echo htmlspecialchars($phone); ?></p>
                    <p>Email: <?php echo htmlspecialchars($email); ?></p>
                    <p>Address: <?php echo htmlspecialchars($address); ?></p>
                </div>
            </div>

            <div class="col-md-9">
                <div class="toggle-buttons">
                    <button class="btn btn-primary" onclick="showSection('requested-appointments')">Request
                        Appointments</button>
                    <button class="btn btn-success" onclick="showSection('approved-appointments')">Approved
                        Appointments</button>
                    <button class="btn btn-info" onclick="showSection('patient-history')">Patient History</button>
                </div>
                <div id="requested-appointments" class="mb-4">
                    <h3 class="section-heading">Requested Appointments</h3>
                    <?php if ($requestedAppointments->num_rows > 0): ?>
                    <div class="row">
                        <?php while ($row = $requestedAppointments->fetch_assoc()): ?>
                        <div class="col-md-4">
                            <div class="card p-3">
                                <h5><?php echo htmlspecialchars($row['patient_name']); ?></h5>
                                <p>Age: <?php echo htmlspecialchars($row['age']); ?></p>
                                <p>Reason: <?php echo htmlspecialchars($row['reason']); ?></p>
                                <p>Date: <?php echo htmlspecialchars($row['appointment_date']); ?></p>
                                <p>Status: <?php echo htmlspecialchars($row['status']); ?></p>
                                <button class="btn btn-approve"
                                    data-id="<?php echo htmlspecialchars($row['appointment_id']); ?>">Approve</button>
                                <button class="btn btn-reschedule">Reschedule</button>
                                <button class="btn btn-cancel">Cancel</button>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                    <?php else: ?>
                    <p>No requested appointments found.</p>
                    <?php endif; ?>
                </div>

                <div id="approved-appointments" class="mb-4" style="display: none;">
                    <h3 class="section-heading">Approved Appointments</h3>
                    <?php if ($approvedAppointments->num_rows > 0): ?>
                    <div class="row">
                        <?php while ($row = $approvedAppointments->fetch_assoc()): ?>
                        <div class="col-md-4">
                            <div class="card p-3 patient-card"
                                data-room="room-<?php echo htmlspecialchars($row['appointment_id']); ?>">
                                <h5><?php echo htmlspecialchars($row['patient_name']); ?></h5>
                                <p>Date: <?php echo htmlspecialchars($row['appointment_date']); ?></p>
                                <p>Time: <?php echo htmlspecialchars($row['appointment_time']); ?></p>
                                <p>Status: <?php echo htmlspecialchars($row['status']); ?></p>
                                <button class="btn btn-success complete-consultation"
                                    data-id="<?php echo htmlspecialchars($row['appointment_id']); ?>">Complete
                                    Consultation</button>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                    <div id="video-call-container"
                        style="margin-top: 20px; height: 500px; width: 100%; border: 1px solid #ccc; display: none;">
                    </div>
                    <?php else: ?>
                    <p>No approved appointments found.</p>
                    <?php endif; ?>
                </div>



                <div id="patient-history" style="display: none;">
                    <h3 class="section-heading">Patient History</h3>
                    <?php if ($patientHistory->num_rows > 0): ?>
                    <div class="row">
                        <?php while ($row = $patientHistory->fetch_assoc()): ?>
                        <div class="col-md-4">
                            <div class="card p-3">
                                <h5><?php echo htmlspecialchars($row['patient_name']); ?></h5>
                                <p>Date: <?php echo htmlspecialchars($row['appointment_date']); ?></p>
                                <p>Notes: <?php echo htmlspecialchars($row['notes']); ?></p>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                    <?php else: ?>
                    <p>No patient history found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

    <footer class="bg-dark text-light py-4" style="margin-top:100px;">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6">
                    <h5 class="text-warning">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li>
                            <a href="#" class="text-light text-decoration-none">About Us</a>
                        </li>
                        <li>
                            <a href="#" class="text-light text-decoration-none">Contact Us</a>
                        </li>
                        <li>
                            <a href="#" class="text-light text-decoration-none">Blogs</a>
                        </li>
                        <li>
                            <a href="#" class="text-light text-decoration-none">Video-consultation</a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-3 col-6">
                    <h5 class="text-warning">Support</h5>
                    <ul class="list-unstyled">
                        <li>
                            <a href="#" class="text-light text-decoration-none">Home</a>
                        </li>
                        <li>
                            <a href="#" class="text-light text-decoration-none">Services</a>
                        </li>
                        <li>
                            <a href="#" class="text-light text-decoration-none">Our Team</a>
                        </li>
                        <li>
                            <a href="#" class="text-light text-decoration-none">Testimonials</a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-3 col-6">
                    <h5 class="text-warning">Contact Detail</h5>
                    <ul class="list-unstyled">
                        <li>Phone: 8303674267</li>
                        <li>
                            Email:
                            <a href="mailto:ayurconnect@gmail.com"
                                class="text-light text-decoration-none">codingdecode@gmail.com</a>
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
                <p class="mb-0">
                    &copy; 2024 CD Care <sup>&trade;</sup>. All Rights Reserved.
                </p>
            </div>
        </div>
    </footer>

    <script>
    function showSection(sectionId) {
        const sections = ['requested-appointments', 'approved-appointments', 'patient-history'];
        sections.forEach(id => {
            document.getElementById(id).style.display = id === sectionId ? 'block' : 'none';
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-approve').forEach(button => {
            button.addEventListener('click', function() {
                const appointmentId = this.getAttribute('data-id');
                fetch('update-appointment-status.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            appointment_id: appointmentId,
                            status: 'approved'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Appointment approved successfully.');
                            location.reload();
                        } else {
                            alert('Error approving appointment: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
            });
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.patient-card').forEach(card => {
            card.addEventListener('click', function() {
                const roomName = this.getAttribute('data-room');
                const domain = "meet.jit.si";

                const videoCallContainer = document.getElementById('video-call-container');
                videoCallContainer.style.display = 'block';

                const options = {
                    roomName: roomName,
                    width: "100%",
                    height: 500,
                    parentNode: videoCallContainer,
                    configOverwrite: {
                        prejoinPageEnabled: false
                    }
                };

                videoCallContainer.innerHTML = "";
                new JitsiMeetExternalAPI(domain, options);
            });
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.complete-consultation').forEach(button => {
            button.addEventListener('click', function() {
                const appointmentId = this.getAttribute('data-id');
                fetch('update-appointment-status.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            appointment_id: appointmentId,
                            status: 'completed'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Consultation completed successfully.');
                            this.closest('.card').remove();
                        } else {
                            alert('Error completing consultation: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
            });
        });
    });
    </script>
    <script src="https://meet.jit.si/external_api.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>