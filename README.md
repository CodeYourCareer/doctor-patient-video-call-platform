<p align="center">
  <img src="https://capsule-render.vercel.app/api?type=waving&color=gradient&customColorList=12,20,25&height=200&section=header&text=CD%20Care&fontSize=55&fontColor=fff&animation=twinkling&fontAlignY=35&desc=Doctor–Patient%20Telemedicine%20Platform%20%7C%20PHP%20%7C%20MySQL%20%7C%20Bootstrap&descAlignY=58&descSize=15" width="100%"/>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white"/>
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white"/>
  <img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black"/>
  <img src="https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white"/>
  <img src="https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white"/>
  <img src="https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white"/>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Status-Completed-brightgreen?style=flat-square"/>
  <img src="https://img.shields.io/badge/License-MIT-blue?style=flat-square"/>
  <img src="https://img.shields.io/badge/Author-Prince%20Kumar%20Yadav-8B5CF6?style=flat-square"/>
  <img src="https://img.shields.io/badge/Type-Full--Stack-orange?style=flat-square"/>
  <img src="https://img.shields.io/badge/Duration-Aug%202024%20–%20Dec%202024-informational?style=flat-square"/>
</p>

---

## 📌 Table of Contents

- [About](#about)
- [Features](#features)
- [Screenshots](#screenshots)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Database Schema](#database-schema)
- [Getting Started](#getting-started)
- [Security](#security)
- [Author](#author)

---

## 📖 About

**CD Care™** is a full-stack **telemedicine web platform** that enables secure, role-based interactions between certified doctors and patients. It also exposes a REST API layer for Android app integration. Built between August and December 2024, it streamlines appointment booking and provides dedicated dashboards for both user roles.

Key highlights:
- 🎥 **In-browser video consultations** powered by the Jit.si API
- 🗓️ **Appointment booking** with date, time, and reason submission
- 💊 **Buy Medicine** module with live stock management
- 📡 **REST API endpoints** for Android app integration
- 👨‍⚕️ Separate role-based dashboards for **Doctors** and **Patients**
- 📄 **Resume upload** during doctor registration

---

## ✨ Features

### 🤒 Patient Dashboard
- ✅ Browse all registered doctors
- ✅ Search doctors by disease (Allergy, Cancer, Diabetes, Heart Disease, Hypertension, Obesity, Stroke, Tuberculosis, Malaria, Asthma, and more)
- ✅ Filter and sort doctor listings
- ✅ Book appointments with date, time, and reason
- ✅ View approved and completed appointment history
- ✅ In-browser video consultation via Jit.si
- ✅ Buy medicine with real-time stock updates
- ✅ View doctor profile (specialty, degree, hospital, experience)

### 🧑‍⚕️ Doctor Dashboard
- ✅ View personal profile (specialty, degree, hospital, DOB, contact)
- ✅ View pending appointment requests with patient name and age
- ✅ View approved appointments
- ✅ View full patient consultation history
- ✅ Update appointment status (pending → approved → rescheduled / consulted)

### 🔐 Authentication
- ✅ Separate login and signup pages for Doctors and Patients
- ✅ Doctor signup includes resume / credential file upload
- ✅ Passwords hashed with `password_hash()` (bcrypt)
- ✅ Session-based access control — every protected page checks role
- ✅ Separate logout handlers for Doctor and Patient

### 📡 REST API (Android Integration)
- ✅ `login.php` — Patient login endpoint (JSON request / response)
- ✅ `update-appointment-status.php` — Update appointment status via JSON

---

## 📸 Screenshots

| Patient Dashboard | Book Appointment |
|---|---|
| ![Patient Dashboard](./Screenshot_(7).png) | ![Book Appointment](./Screenshot_(12).png) |

> _CD Care features a dark-themed UI optimized for healthcare use._

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| Frontend | HTML5, CSS3, JavaScript, Bootstrap 5 |
| Backend | PHP 8.x |
| Database | MySQL 8.0 (MySQLi extension) |
| Video Call | Jit.si External API |
| Auth | PHP Sessions + Role-Based Access |
| Security | `password_hash()` bcrypt, prepared statements (partial) |
| Server | Apache (XAMPP / WAMP) |
| Version Control | Git & GitHub |

---

## 📁 Project Structure

```
DVA/
├── assets/
│   ├── css/
│   │   ├── doctors-dashboard.css
│   │   ├── login-doctor.css
│   │   ├── login.css
│   │   ├── patient-dashboard.css
│   │   ├── profile.css
│   │   ├── signup-doctor.css
│   │   └── signup.css
│   ├── images/                             # SVG illustrations & icons
│   ├── js/
│   │   └── script.js
│   └── md-images/                          # README screenshots
├── uploads/
│   ├── profile/                            # Doctor profile photos
│   └── resumes/                            # Doctor credential uploads
├── bkap.php                                # Book appointment (primary flow)
├── book-appointment.php                    # Alternate appointment booking
├── buy-medicine.php                        # Medicine store (uses 'medc' DB)
├── connection.php                          # MySQLi DB connection
├── d-logout.php                            # Doctor logout
├── doctors-dashboard.php                   # Doctor dashboard
├── function.php                            # Helper functions (session check etc.)
├── login-doctor.php                        # Doctor login page
├── login-patient.php                       # Patient login page
├── login.php                               # REST API — patient login (Android)
├── p-logout.php                            # Patient logout
├── patient-appointment.php                 # Patient appointments + Jit.si video call
├── patient-dashboard.php                   # Patient dashboard — browse & search doctors
├── process-doctor-signup.php               # Doctor registration handler
├── process-login-doctor.php                # Doctor login handler
├── process-patient-signup.php              # Patient registration handler
├── profile.php                             # Doctor public profile view
├── signup-doctor.php                       # Doctor registration form
├── signup-patient.php                      # Patient registration form
└── update-appointment-status.php           # REST API — update appointment status (JSON)
```

---

## 🗄️ Database Schema

> This project uses **two databases**: `dva` for the main platform and `medc` for the medicine store.

```sql
-- ─────────────────────────────────────
-- DATABASE: dva  (main platform)
-- ─────────────────────────────────────

-- Doctors Table
CREATE TABLE doctors (
    doctor_id       INT PRIMARY KEY AUTO_INCREMENT,
    full_name       VARCHAR(100) NOT NULL,
    dob             DATE,
    email           VARCHAR(100) UNIQUE NOT NULL,
    phone           VARCHAR(20),
    license_number  VARCHAR(100),
    address         TEXT,
    resume_path     VARCHAR(255),           -- uploaded credential file path
    password        VARCHAR(255) NOT NULL,  -- bcrypt hashed
    specialty       VARCHAR(200),
    experience      INT,
    degree          VARCHAR(100),
    hospital_name   VARCHAR(200),
    profile         VARCHAR(255),           -- profile photo path
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Patients Table
CREATE TABLE patients (
    patient_id        INT PRIMARY KEY AUTO_INCREMENT,
    full_name         VARCHAR(100) NOT NULL,
    age               INT,
    previous_disease  VARCHAR(200),
    email             VARCHAR(100) UNIQUE NOT NULL,
    phone             VARCHAR(20),
    password          VARCHAR(255) NOT NULL, -- bcrypt hashed
    created_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Appointments Table
CREATE TABLE appointments (
    appointment_id    INT PRIMARY KEY AUTO_INCREMENT,
    doctor_id         INT NOT NULL,
    patient_id        INT NOT NULL,
    appointment_date  DATE NOT NULL,
    appointment_time  TIME NOT NULL,
    reason            TEXT,
    status            ENUM('pending','approved','rescheduled','consulted','completed')
                      DEFAULT 'pending',
    created_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (doctor_id)  REFERENCES doctors(doctor_id),
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id)
);

-- ─────────────────────────────────────
-- DATABASE: medc  (medicine store)
-- ─────────────────────────────────────

-- Medicines Table
CREATE TABLE medicines (
    medicine_id  INT PRIMARY KEY AUTO_INCREMENT,
    name         VARCHAR(200) NOT NULL,
    stock        INT DEFAULT 0,
    price        DECIMAL(10,2),
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## 🚀 Getting Started

### Prerequisites
- XAMPP / WAMP / LAMP (Apache + PHP + MySQL)
- PHP 8.0+
- MySQL 8.0+
- Web browser

### Installation

```bash
# 1. Clone the repository
git clone https://github.com/CodeYourCareer/doctor-patient-video-call-platform.git

# 2. Move to your server root
# XAMPP on Windows:
cp -r doctor-patient-video-call-platform/ C:/xampp/htdocs/DVA/

# 3. Start Apache & MySQL from XAMPP Control Panel

# 4. Create both databases
# Open: http://localhost/phpmyadmin
# Create database: dva       → Import: database/dva.sql
# Create database: medc      → Import: database/medc.sql

# 5. Configure database connection — edit connection.php:
```

```php
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$servername = "localhost";
$username   = "root";   // your MySQL username
$password   = "";       // your MySQL password
$dbname     = "dva";
$port       = 3306;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>
```

> ⚠️ **Never commit `connection.php` with real credentials.** Add it to `.gitignore` or use environment variables.

```bash
# 6. Open in browser
http://localhost/DVA/login-patient.php    # Patient entry point
http://localhost/DVA/login-doctor.php     # Doctor entry point
```

### Getting Started

| Role | Entry Point | Action |
|------|-------------|--------|
| Patient | `login-patient.php` | Register via `signup-patient.php` first |
| Doctor | `login-doctor.php` | Register via `signup-doctor.php` (resume upload required) |

---

## 🔒 Security

| Practice | Status | Detail |
|---|---|---|
| Password Hashing | ✅ Implemented | `password_hash()` with bcrypt used throughout |
| Prepared Statements | ⚠️ Partial | Used in `doctors-dashboard.php`, `profile.php`, `update-appointment-status.php`; raw queries still present in `bkap.php`, `book-appointment.php`, `patient-appointment.php` |
| XSS Prevention | ✅ Implemented | Output sanitized with `htmlspecialchars()` in all dashboards |
| Session Access Control | ✅ Implemented | Role check at the top of every protected page |
| File Upload Validation | ⚠️ Basic | Resume uploads lack MIME-type check — add validation before production |
| Hardcoded Credentials | ❌ Present | `connection.php` contains DB credentials — move to `.env` for production |

> **For production use:** migrate all raw queries to prepared statements, validate uploaded file MIME types, and store credentials outside the codebase.

---




## 📸 Screenshots
### Login Page (Patient Side)
![Login as Patient](./Screenshot_(6).png)

### Patients Dashboard
![Patient Dashboard](./Screenshot_(7).png)

### Login Page (Doctor Side)
![Login as Doctor](./Screenshot_(8).png)
### Doctors Dashboard
![Doctor Dashboard](./Screenshot_(9).png)
### Doctors Profile
![Doctors Profile](./Screenshot_(10).png)
### Appointments booked by a Patient  Dashboard and approved by Doctors
![Appointments booked by a Patient  Dashboard and approved by Doctors](./Screenshot_(11).png)
### Book Appointment
![Book Appointment](./Screenshot_(12).png)
### Request Appointment(Doctors Dashboard)
![Request Appointment(Doctors Dashboard)](./Screenshot_(9).png)
### Approved Appointment(Doctors Dashboard)
![Approved Appointment(Doctors Dashboard)](./Screenshot_(13).png)
### History Appointment(Doctors Dashboard)
![History Appointment(Doctors Dashboard)](./Screenshot_(14).png)

---

## 👨‍💻 Author

<p align="center">
  <b>Prince Kumar Yadav</b><br/>
  B.Tech CSE — Vishveshwarya Group of Institutions, Greater Noida<br/><br/>
  <a href="https://www.linkedin.com/in/prince-kumar-yadav-a569a8371/"><img src="https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white"/></a>
  <a href="https://github.com/CodeYourCareer"><img src="https://img.shields.io/badge/GitHub-181717?style=for-the-badge&logo=github&logoColor=white"/></a>
  <a href="mailto:princeyad589@gmail.com"><img src="https://img.shields.io/badge/Gmail-D14836?style=for-the-badge&logo=gmail&logoColor=white"/></a>
</p>

<p align="center">
  <img src="https://capsule-render.vercel.app/api?type=waving&color=gradient&customColorList=12,20,25&height=100&section=footer&animation=twinkling" width="100%"/>
</p>


Feel free to contribute or report issues in the [Issues section](https://github.com/your-username/doctor-patient-video-call-platform/issues).
