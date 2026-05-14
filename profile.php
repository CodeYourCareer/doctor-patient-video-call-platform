<?php
session_start();

$conn = new mysqli(
    'localhost', 
    'projectuser',          // MySQL Workbench user
    'StrongPassword123',    // Workbench password
    'dva', 
    3306                    // Workbench port (change if needed)
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Patient must click doctor profile, so GET doctor_id is correct
if (!isset($_GET['doctor_id'])) {
    echo "<p>Invalid doctor selected. Please try again.</p>";
    exit;
}

$doctor_id = $_GET['doctor_id'];

$doctor_query = $conn->prepare("
    SELECT doctor_id, full_name, specialty, experience, degree, hospital_name, email, phone, profile 
    FROM doctors 
    WHERE doctor_id = ?
");

$doctor_query->bind_param("i", $doctor_id);
$doctor_query->execute();
$result = $doctor_query->get_result();

if ($result->num_rows == 0) {
    echo "<p>Doctor not found.</p>";
    exit;
}

$doctor = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dynamic Doctor Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/profile.css" />
</head>

<body class="text-light">
    <div class="container py-5">
        <div class="text-center">
            <img src="uploads/profile/abc.png" class="rounded-circle mb-3" alt="Doctor Profile" style="height:175px;" />
            <h2 id="doctor-name"><?php echo htmlspecialchars($doctor['full_name']); ?></h2>
            <p class="heading" id="specialization">
                <?php echo htmlspecialchars($doctor['specialty']); ?><br />
                <?php echo htmlspecialchars($doctor['hospital_name']); ?>
            </p>
        </div>

        <section class="mt-5">
            <h4 class="heading">Biography</h4>
            <div class="border rounded p-3 mt-2" id="biography">
                Dr. <?php echo htmlspecialchars($doctor['full_name']); ?> is a highly skilled and board-certified
                <?php echo htmlspecialchars($doctor['specialty']); ?> with over
                <?php echo htmlspecialchars($doctor['experience']); ?> years of experience in providing exceptional
                patient care. He specializes in the diagnosis, treatment, and management of various medical conditions,
                offering personalized treatment plans and the latest medical technologies to ensure the best outcomes
                for his patients.
            </div>
        </section>

        <section class="mt-5">
            <h4 class="heading">Specialties</h4>
            <div class="d-flex flex-wrap gap-2 mt-2" id="specialties">
                <span class="badge bg-secondary"><?php echo htmlspecialchars($doctor['specialty']); ?></span>
            </div>
        </section>

        <section class="row mt-5">
            <div class="col-md-6">
                <h4 class="heading">Experience</h4>
                <ul class="list-group bg-dark border rounded mt-2" id="experience">
                    <li class="list-group-item bg-dark text-light border-secondary">
                        Senior Consultant at <?php echo htmlspecialchars($doctor['hospital_name']); ?>
                    </li>
                    <li class="list-group-item bg-dark text-light border-secondary">
                        <?php echo htmlspecialchars($doctor['experience']); ?> years in medical practice
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <h4 class="heading">Education</h4>
                <ul class="list-group bg-dark border rounded mt-2" id="education">
                    <li class="list-group-item bg-dark text-light border-secondary">
                        <?php echo htmlspecialchars($doctor['degree']); ?>
                    </li>
                </ul>
            </div>
        </section>

        <section class="mt-5">
            <h4 class="heading">Contact</h4>
            <ul class="list-group bg-dark border rounded mt-2" id="contact">
                <li class="list-group-item bg-dark text-light border-secondary">
                    <?php echo htmlspecialchars($doctor['email']); ?>
                </li>
                <li class="list-group-item bg-dark text-light border-secondary">
                    <?php echo htmlspecialchars($doctor['phone']); ?>
                </li>
                <li class="list-group-item bg-dark text-light border-secondary">
                    <?php echo htmlspecialchars($doctor['hospital_name']); ?>
                </li>
            </ul>
        </section>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>