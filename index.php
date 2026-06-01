<?php
session_start();

/* AUTO REDIRECT IF USER IS ALREADY LOGGED IN */
if (isset($_SESSION['role'])) {

    if ($_SESSION['role'] == "admin") {
        header("Location: dashboard/admin.php");
        exit();
    } elseif ($_SESSION['role'] == "manager") {
        header("Location: dashboard/Manager/manager_dashboard.php");
        exit();
    } elseif ($_SESSION['role'] == "driver") {
        header("Location: dashboard/driver/index.php");
        exit();
    } elseif ($_SESSION['role'] == "mechanic") {
        header("Location: dashboard/mechanic_dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>AAU Vehicle Management System</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Segoe UI;
        }

        body {
            background: linear-gradient(120deg, #0f2027, #203a43, #2c5364);
            color: white;
            overflow-x: hidden;
        }

        /* NAVBAR */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 50px;
            background: rgba(60, 13, 148, 0.4);
            backdrop-filter: blur(10px);
        }

        .navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 40px;
    background:rgba(0,0,0,0.5);
    backdrop-filter:blur(10px);
}

        .logo{
            display:flex;
            align-items:center;
            gap:10px;
            color:#00eaff;
            font-weight:bold;
            font-size:18px;
        }

        .logo img{
            height:45px;
            width:auto;
            object-fit:contain;
        }

        .nav-links {
            display: flex;
            gap: 25px;
        }

        .nav-links a {
            text-decoration: none;
            color: white;
            padding: 8px 14px;
            border-radius: 20px;
            transition: 0.3s;
        }

        .nav-links a:hover {
            color: #00eaff;
        }

        .btn {
            padding: 14px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-login {
            background: #00f7ff;
            color: black;
        }

        .btn-login:hover {
            box-shadow: 0 0 20px #00f7ff;
        }

        /* HERO */
        .hero {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .hero h1 {
            font-size: 55px;
        }

        .hero p {
            margin-top: 20px;
            font-size: 18px;
            color: #cbefff;
        }

        .hero-buttons {
            margin-top: 40px;
            display: flex;
            gap: 20px;
        }

        .btn-about {
            border: 2px solid #00f7ff;
            color: #00f7ff;
        }

        .btn-about:hover {
            background: #00f7ff;
            color: black;
        }

        /* FEATURES */
        .features {
            padding: 100px 60px;
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .card {
            width: 280px;
            padding: 25px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            text-align: center;
        }

        .card h3 {
            color: #0b1414;
        }

        /* FOOTER */
        .footer {
            text-align: center;
            padding: 20px;
            background: black;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">

    <!-- LOGO -->
    <div class="logo">
<img src="/AAU/assets/image/aau logo.png" alt="AAU Logo">
        <span>AAU-VMS</span>
    </div>

    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <a href="auth/login.php" class="btn btn-login">Login</a>
    </div>

</div>

    <!-- HERO -->
    <section class="hero">

        <h1>Web and Android Based <br> Vehicle Management System</h1>

        <p>Smart digital transport management for the university</p>

        <div class="hero-buttons">
            <a href="auth/login.php" class="btn btn-login">Login System</a>
            <a href="about.php" class="btn btn-about">Learn More</a>
        </div>

    </section>

    <!-- FEATURES -->
    <section class="features">

        <div class="card">
            <h3>Vehicle Tracking</h3>
            <p>Monitor all university vehicles in real-time.</p>
        </div>

        <div class="card">
            <h3>Driver Management</h3>
            <p>Assign and manage drivers efficiently.</p>
        </div>

        <div class="card">
            <h3>Transport Requests</h3>
            <p>Submit and approve requests digitally.</p>
        </div>

    </section>

    <!-- FOOTER -->
    <div class="footer">
        <p>© 2026 Addis Ababa University Vehicle Management System</p>
    </div>

</body>

</html>