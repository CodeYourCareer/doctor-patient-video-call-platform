<?php
include ('connection.php');
if (!isset($_SESSION['patient_id'])) {
    header("Location: login-patient.php");
    exit();
}

$patient_name = $_SESSION['patient_name'];
$patient_id = $_SESSION['patient_id'];

$sql = "SELECT * FROM doctors";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Patients-Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/patient-dashboard.css">
    <style>
    .btn-appointment {
        background-color: #4cae4f;
        text-decoration: none;
        color: #fff;
        border: none;
        padding: 10px 17px;
        border-radius: 5px;
    }

    .btn-appointment:hover {
        background-color: #04fc0d;
    }

    .btn-profile {
        background-color: #444;
        color: #fff;
        border: none;
        padding: 10px 17px;
        text-decoration: none;
        border-radius: 5px;
    }

    .btn-profile:hover {
        background-color: #555;
    }

    .text-warning {
        color: #4cae4f !important;
    }

    .nav-bar {
        background: #121212 !important;
        color: #fff;
    }

    .custom-navbar {
        height: calc(56px + 15px);
    }

    .custom-navbar .navbar-brand,
    .custom-navbar .nav-link {
        line-height: calc(56px + 15px);
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-dark text-white custom-navbar">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">CD care <sup>&trade;</sup></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active text-white" aria-current="page"
                            href="patient-dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="patient-appointment.php">Appointments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="buy-medicine.php">Buy Medicine</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="p-logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>



    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 sidebar">
                <h4>Search Doctor By Disease</h4>
                <input type="text" class="form-control mb-3" placeholder="Search diseases..." />
                <label><input type="checkbox" class="me-2" /> Allergy</label><br />
                <label><input type="checkbox" class="me-2" /> Symptom</label><br />
                <label><input type="checkbox" class="me-2" /> Cancer</label><br />
                <label><input type="checkbox" class="me-2" /> Diabetes</label><br />
                <label><input type="checkbox" class="me-2" /> Heart Disease</label><br />
                <label><input type="checkbox" class="me-2" /> Hypertension</label><br />
                <label><input type="checkbox" class="me-2" /> Obesity</label><br />
                <label><input type="checkbox" class="me-2" /> Stroke</label><br />
                <label><input type="checkbox" class="me-2" /> Tuberculosis</label><br />
                <label><input type="checkbox" class="me-2" /> Malaria</label><br />
                <label><input type="checkbox" class="me-2" /> Asthma</label>
            </div>

            <div class="col-md-9">
                <div class="user">
                    <h3 class="mb-4 text-success"><?php echo htmlspecialchars($patient_name); ?></h3>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <input type="text" class="search-bar" placeholder="Search by Disease" />
                    <button class="btn-filter">Sort By</button>
                    <button class="btn-filter">Filter</button>
                </div>
                <div class="container mt-5">
                    <h3 class="mb-4 text-success">Doctors</h3>
                    <div class="row">
                        <?php
              if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                      echo '
                      <div class="col-md-6">
                          <div class="doctor-card">
                              <div class="d-flex align-items-center">
                                  <img src="uploads/profile/abc.png" alt="Doctor Image" class="rounded-circle me-3" style="height:100px;" />
                                  <div>
                                      <h5>Dr.' . htmlspecialchars($row['full_name']) . '</h5>
                                      <p class="mb-1">Degree: ' . htmlspecialchars($row['degree']) . '</p>
                                      <p class="mb-1">
                                          Specialty: ' . htmlspecialchars($row['specialty']) . '
                                      </p>
                                      <p class="mb-0">Experience: ' . htmlspecialchars($row['experience']) . ' years</p>
                                  </div>
                              </div>
                              <div class="mt-3">
                                  <a class="btn-appointment" href="bkap.php?doctor_id=' . htmlspecialchars($row['doctor_id']) . '">Book Appointment</a>
                                  <a class="btn-profile" href="profile.php?doctor_id=' . htmlspecialchars($row['doctor_id']) .'">View Profile</a>
                              </div>
                          </div>
                      </div>';
                  }
              } else {
                  echo '<p>No doctors found in the database.</p>';
              }
              ?>
                    </div>
                </div>
                <button class="view-more mt-4">View More</button>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-light py-4">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>