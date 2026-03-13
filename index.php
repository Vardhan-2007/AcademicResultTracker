<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Smart Student Result Management</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

/* Default Light Theme */
body {
    font-family: 'Segoe UI', sans-serif;
    transition: background 0.4s, color 0.4s;
    overflow-x: hidden;
    background: #f4f6f9;
}

/* Dark Mode */
.dark-mode {
    background: #121212 !important;
    color: white !important;
}

/* Navbar */
.navbar {
    background: linear-gradient(90deg, #4e73df, #1cc88a);
}

/* Hero Section */
.hero {
    height: 90vh;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

/* Floating Animated Blobs */
.blob {
    position: absolute;
    border-radius: 50%;
    opacity: 0.4;
    animation: float 8s infinite ease-in-out;
}

.blob1 {
    width: 300px;
    height: 300px;
    background: #4e73df;
    top: 10%;
    left: 10%;
}

.blob2 {
    width: 250px;
    height: 250px;
    background: #e83e8c;
    bottom: 10%;
    right: 15%;
}

/* Blob Animation */
@keyframes float {
    0% {transform: translateY(0px);}
    50% {transform: translateY(-30px);}
    100% {transform: translateY(0px);}
}

/* Main Card */
.hero-card {
    background: white;
    padding: 50px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    text-align: center;
    animation: fadeIn 1.5s ease;
    z-index: 2;
}

.dark-mode .hero-card {
    background: #1e1e1e;
    color: white;
}

/* Title */
.hero-title {
    font-size: 32px;
    font-weight: 700;
}

/* Buttons */
.btn-custom {
    width: 220px;
    margin: 8px;
    border-radius: 30px;
    font-weight: 600;
    transition: 0.3s;
}

.btn-custom:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

/* Fade Animation */
@keyframes fadeIn {
    from {opacity: 0; transform: translateY(30px);}
    to {opacity: 1; transform: translateY(0);}
}

/* Footer */
.footer {
    background: #343a40;
    color: white;
    text-align: center;
    padding: 15px;
}

</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark">
<div class="container">
<a class="navbar-brand text-white fw-bold" href="kpi_dashboard.php">
SSRMS Portal
</a>

<button onclick="toggleMode()" class="btn btn-light btn-sm">
🌙 Toggle Mode
</button>

</div>
</nav>

<!-- HERO SECTION -->
<div class="hero">

<div class="blob blob1"></div>
<div class="blob blob2"></div>

<div class="hero-card">

<div class="hero-title">
Smart Student Result Management System
</div>

<p class="text-muted mt-2">
Secure • Role-Based • Real-Time Academic Platform
</p>

<div class="mt-4">
<a href="student_login.php" class="btn btn-primary btn-lg btn-custom">Student Login</a>
<br>
<a href="faculty_login.php" class="btn btn-success btn-lg btn-custom">Faculty Login</a>
<br>
<a href="admin_login.php" class="btn btn-danger btn-lg btn-custom">Admin Login</a>
</div>

</div>
</div>

<!-- FOOTER -->
<div class="footer">
© <?php echo date("Y"); ?> Smart Student Result Management | All Rights Reserved
</div>

<script>

/* Remember Dark Mode */
if(localStorage.getItem("mode") === "dark"){
    document.body.classList.add("dark-mode");
}

function toggleMode() {
    document.body.classList.toggle("dark-mode");

    if(document.body.classList.contains("dark-mode")){
        localStorage.setItem("mode","dark");
    } else {
        localStorage.setItem("mode","light");
    }
}

</script>

</body>
</html>