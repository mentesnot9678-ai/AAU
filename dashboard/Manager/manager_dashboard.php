<?php
session_start();
include("../../config/db.php");

/* =========================
   AUTH CHECK
========================= */
if (!isset($_SESSION['role']) || $_SESSION['role'] != "manager") {
    header("Location: ../../auth/login.php");
    exit();
}

/* =========================
   STATS
========================= */
$totalTrips = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM trips"));
$pendingTrips = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM trips WHERE status='Pending'"));
$activeTrips = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM trips WHERE status='On Trip'"));
$completedTrips = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM trips WHERE status='Completed'"));

$maintenanceRequests = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM maintenance_requests"));
$totalUsers = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manager Dashboard</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            color: white;
            font-family: 'Segoe UI', Arial;
            display: flex;
        }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            padding: 20px;
            overflow-y: auto;
        }

        .sidebar h2 {
            color: #00f7ff;
            margin-bottom: 20px;
        }

        .sidebar a {
            display: block;
            color: #ccc;
            margin: 10px 0;
            text-decoration: none;
            padding: 8px 10px;
            border-radius: 8px;
            transition: 0.3s;
            font-size: 14px;
        }

        .sidebar a:hover {
            background: rgba(0, 247, 255, 0.2);
            color: #00f7ff;
        }

        .sidebar a.active {
            background: #00f7ff;
            color: black;
            font-weight: bold;
        }

        .main {
            margin-left: 260px;
            padding: 30px;
            width: 100%;
        }

        .header h1 {
            font-size: 26px;
            color: #00f7ff;
            margin-bottom: 20px;
        }

        /* CARDS */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
        }

        .card {
            padding: 20px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(12px);
            text-align: center;
        }

        .card p {
            font-size: 28px;
            margin-top: 8px;
            font-weight: bold;
            color: #00f7ff;
        }

        .box {
            margin-top: 30px;
            background: rgba(255, 255, 255, 0.06);
            padding: 20px;
            border-radius: 14px;
        }

        .item {
            padding: 15px;
            margin-bottom: 12px;
            border-radius: 12px;
            background: rgba(0, 0, 0, 0.4);
        }

        .status {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
        }

        .pending { background: orange; }
        .active { background: #3498db; }
        .completed { background: #2ecc71; }
    </style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <h2>AAU VMS</h2>

    <!-- DASHBOARD -->
    <a href="manager_dashboard.php" class="active">Dashboard</a>

    <!-- COMMENTS -->
    <a href="manager_view_comments.php">Driver Messages</a>
    <a href="manager_view_staff_comments.php">Staff Comments</a>

    <hr style="border:0.5px solid #444; margin:10px 0;">

    <!-- TRIPS -->
    <a href="trips.php">Manage Trips</a>
    <a href="add_trip.php">Add Trip</a>

    <hr style="border:0.5px solid #444; margin:10px 0;">

    <!-- VEHICLES -->
    <a href="manager_vehicles.php">Vehicles</a>
    <a href="add_vehicle.php">Add Vehicle</a>

    <hr style="border:0.5px solid #444; margin:10px 0;">

    <!-- ASSIGNMENTS -->
    <a href="assign_driver.php">Assign Driver</a>
    <a href="assign_vehicle.php">Assign Vehicle</a>

    <hr style="border:0.5px solid #444; margin:10px 0;">

    <!-- MAINTENANCE REQUESTES -->
        <a href="manage_requests.php">
         Driver Service Requests
        </a>
    <!-- GATE EXIT REQUESTES -->
    <a href="manage_exit_requests.php" class="active">
     Gate Exit Requests
</a>
    <hr style="border:0.5px solid #444; margin:15px 0;">
    <!-- Generate Report -->
     <a href="manager_report.php" class="btn">
    Generate Report
    <!-- Fuel Blance-->
<a href="fuel_report.php" class="btn">Fuel Balance</a>
    <!-- LOGOUT -->
    <a href="../../auth/logout.php">Logout</a>

</div>

<!-- MAIN -->
<div class="main">

    <div class="header">
        <h1>Manager Dashboard</h1>
    </div>

    <!-- STATS -->
    <div class="cards">
        <div class="card">
            <h3>Total Trips</h3>
            <p><?php echo $totalTrips; ?></p>
        </div>

        <div class="card">
            <h3>Users</h3>
            <p><?php echo $totalUsers; ?></p>
        </div>

        <div class="card">
            <h3>Pending Trips</h3>
            <p><?php echo $pendingTrips; ?></p>
        </div>

        <div class="card">
            <h3>Active Trips</h3>
            <p><?php echo $activeTrips; ?></p>
        </div>

        <div class="card">
            <h3>Completed Trips</h3>
            <p><?php echo $completedTrips; ?></p>
        </div>

        <div class="card">
            <h3>Maintenance</h3>
            <p><?php echo $maintenanceRequests; ?></p>
        </div>
    </div>

</div>

</body>
</html>