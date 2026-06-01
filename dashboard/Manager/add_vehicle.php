<?php
session_start();

// FIXED PATH
require_once __DIR__ . '/../../config/db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != "manager"){
    header("Location: ../auth/login.php");
    exit();
}
// Handle form submission
if(isset($_POST['add'])){
    $name = $_POST['vehicle_name'];
    $plate = $_POST['plate_number'];
    $driver = $_POST['driver'];
    $status = $_POST['status'];
    $service = $_POST['service']; // new
    $service_date = $_POST['service_date']; // new
    $location = $_POST['location']; // new

    $sql = "INSERT INTO vehicles (vehicle_name, plate_number, driver, status, service, service_date, location)
            VALUES ('$name', '$plate', '$driver', '$status', '$service', '$service_date', '$location')";
    if(mysqli_query($conn,$sql)){
        header("Location: vehicles.php");
        exit();
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Vehicle - Manager</title>
<link rel="stylesheet" href="../assets/css/dashboard.css">
<style>
body { background: linear-gradient(120deg,#0f2027,#203a43,#2c5364); color:white; font-family:'Segoe UI'; }
.main { margin-left:250px; padding:20px; }
form { background: rgba(0,0,0,0.5); padding:20px; border-radius:10px; max-width:600px; margin:auto; }
input, select, textarea { width:100%; padding:10px; margin:10px 0; border-radius:6px; border:none; }
textarea { resize:vertical; height:80px; }
button { padding:10px 20px; background:#00f7ff; color:black; border:none; border-radius:6px; cursor:pointer; }
button:hover { box-shadow:0 0 15px #00f7ff; transform:translateY(-2px); }
.back-btn { background:#ef4444; color:white; text-decoration:none; padding:10px 20px; border-radius:6px; margin-right:10px; display:inline-block; }
.back-btn:hover { box-shadow:0 0 15px #ef4444; transform:translateY(-2px); }
.error { color:#ff4d4d; margin-bottom:15px; }
</style>
</head>
<body>

<div class="main">
<h1>Add Vehicle</h1>

<?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

<form method="POST">
    <label>Vehicle Name</label>
    <input type="text" name="vehicle_name" required>

    <label>Plate Number</label>
    <input type="text" name="plate_number" required>

    <label>Driver</label>
    <input type="text" name="driver">

    <label>Status</label>
    <select name="status">
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
    </select>

    <label>Service / Description</label>
    <textarea name="service" placeholder="Oil change, repair, inspection..."></textarea>

    <label>Date of Last Service</label>
    <input type="date" name="service_date">

    <label>Vehicle Location (Map / Coordinates)</label>
    <input type="text" name="location" placeholder="Add map link or coordinates">

    <div style="margin-top:15px;">
        <a href="vehicles.php" class="back-btn">Back</a>
        <button type="submit" name="add">Add Vehicle</button>
    </div>
</form>
</div>

</body>
</html>