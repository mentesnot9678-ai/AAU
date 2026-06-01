<?php
session_start();
include("../../config/db.php");

/* DRIVER ONLY */
if (!isset($_SESSION['role']) || $_SESSION['role'] != "driver") {
    header("Location: ../../auth/login.php");
    exit();
}

$username = $_SESSION['user'] ?? "Driver";

/* =========================
   TRIPS
========================= */
$trips = mysqli_query($conn, "
    SELECT t.*, v.vehicle_name, v.plate_number
    FROM trips t
    LEFT JOIN vehicles v ON t.vehicle_id = v.id
    WHERE t.driver='$username'
    ORDER BY t.id DESC
");

/* =========================
   SERVICE REQUESTS 
========================= */
$services = mysqli_query($conn, "
    SELECT *
    FROM service_requests
    WHERE driver_id = (
        SELECT id FROM users WHERE username='$username' LIMIT 1
    )
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Driver Dashboard</title>

<style>
body{
    background:#0f2027;
    color:white;
    font-family:Segoe UI;
}

/* SIDEBAR */
.sidebar{
    width:220px;
    position:fixed;
    height:100%;
    background:#111827;
    padding-top:30px;
}

.sidebar h2{
    color:#00f7ff;
    text-align:center;
}

.sidebar a{
    display:block;
    color:white;
    padding:12px;
    margin:5px;
    text-decoration:none;
}

.sidebar a:hover{
    background:#00f7ff;
    color:black;
}

/* MAIN */
.main{
    margin-left:240px;
    padding:20px;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    background:rgba(255,255,255,0.05);
    margin-bottom:40px;
}

th,td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid rgba(255,255,255,0.1);
}

th{
    background:#111827;
    color:#00f7ff;
}

/* STATUS */
.status{
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:bold;
}

.pending{background:green;color:black;}
.approved{background:#22c55e;color:white;}
.progress{background:#f97316;color:white;}
.completed{background:#9333ea;color:white;}
.rejected{background:red;color:white;}
.fixed{background:#10b981;color:white;}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>AAU VMS</h2>

    <a href="index.php">Dashboard</a>
    <a href="driverReport.php">Trip Reports</a>
    <a href="submit_service_request.php">Service Request</a>
    <a href="driverReport.php">View Trips</a>
    <a href="driver_comment.php">Write Comment</a>
    <a href="../../auth/logout.php">Logout</a>
</div>

<div class="main">

<h1>Welcome, <?php echo htmlspecialchars($username); ?></h1>

<!-- ================= TRIPS ================= -->
<h2>My Assigned Trips</h2>

<table>
<tr>
    <th>ID</th>
    <th>Vehicle</th>
    <th>Plate</th>
    <th>Destination</th>
    <th>Date</th>
    <th>Status</th>
</tr>

<?php while($trip = mysqli_fetch_assoc($trips)): ?>

<?php $status = strtolower($trip['status']); ?>

<tr>
    <td><?php echo $trip['id']; ?></td>
    <td><?php echo htmlspecialchars($trip['vehicle_name'] ?? 'N/A'); ?></td>
    <td><?php echo htmlspecialchars($trip['plate_number'] ?? 'N/A'); ?></td>
    <td><?php echo htmlspecialchars($trip['destination']); ?></td>
    <td><?php echo htmlspecialchars($trip['trip_date']); ?></td>

    <td>
        <?php
        if($status == 'approved'){
            echo '<span class="status approved">Approved</span>';
        } elseif($status == 'in progress'){
            echo '<span class="status progress">In Progress</span>';
        } elseif($status == 'completed'){
            echo '<span class="status completed">Completed</span>';
        } elseif($status == 'rejected'){
            echo '<span class="status rejected">Rejected</span>';
        } elseif($status == 'fixed'){
            echo '<span class="status fixed">Fixed</span>';
        } else {
            echo '<span class="status pending">Pending</span>';
        }
        ?>
    </td>
</tr>

<?php endwhile; ?>

</table>


<!-- ================= SERVICE REQUESTS (SYNCED WITH MECHANIC) ================= -->
<h2>My Service Requests</h2>

<table>
<tr>
    <th>ID</th>
    <th>Issue</th>
    <th>Status</th>
    <th>Submitted At</th>
</tr>

<?php while($s = mysqli_fetch_assoc($services)): ?>

<?php 
$st = strtolower($s['status']); 
?>

<tr>
    <td><?php echo $s['id']; ?></td>
    <td><?php echo htmlspecialchars($s['issue']); ?></td>

    <td>
        <?php
        if($st == 'pending'){
            echo '<span class="status pending">Pending</span>';

        } elseif($st == 'accepted'){
            echo '<span class="status approved">Accepted</span>';

        } elseif($st == 'in repair'){
            echo '<span class="status progress">In Repair</span>';

        } elseif($st == 'fixed'){
            echo '<span class="status completed">Fixed</span>';

        } elseif($st == 'unrepairable'){
            echo '<span class="status rejected">Unrepairable</span>';

        } elseif($st == 'rejected'){
            echo '<span class="status rejected">Rejected</span>';

        } else {
            echo '<span class="status pending">Pending</span>';
        }
        ?>
    </td>

    <td><?php echo $s['created_at'] ?? '-'; ?></td>
</tr>

<?php endwhile; ?>

</table>