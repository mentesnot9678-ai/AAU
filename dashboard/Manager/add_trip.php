<?php
session_start();
require_once __DIR__ . '/../../config/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != "manager") {
    header("Location: ../auth/login.php");
    exit();
}

/* =========================
   FETCH DATA
========================= */
$vehicles = mysqli_query($conn, "SELECT * FROM vehicles");

$drivers = mysqli_query($conn, "SELECT username FROM users WHERE role='driver'");
$staffs  = mysqli_query($conn, "SELECT username FROM users WHERE role='staff'");

/* =========================
   ADD TRIP
========================= */
if (isset($_POST['add_trip'])) {

    $vehicle_id  = mysqli_real_escape_string($conn, $_POST['vehicle_id']);
    $driver      = mysqli_real_escape_string($conn, $_POST['driver']);
    $staff       = mysqli_real_escape_string($conn, $_POST['staff']);
    $destination = mysqli_real_escape_string($conn, $_POST['destination']);
    $trip_date   = mysqli_real_escape_string($conn, $_POST['trip_date']);

    $status = "Pending Staff Approval";

    $sql = "INSERT INTO trips 
            (vehicle_id, driver, staff, destination, trip_date, status)
            VALUES 
            ('$vehicle_id', '$driver', '$staff', '$destination', '$trip_date', '$status')";

    if (mysqli_query($conn, $sql)) {
        header("Location: trips.php");
        exit();
    } else {
        die("Insert failed: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Trip</title>

<style>
body{
    margin:0;
    font-family:Segoe UI;
    background:#0f172a;
    color:white;
}

.main{
    margin-left:250px;
    padding:30px;
}

.form-box{
    max-width:500px;
    background:rgba(255,255,255,0.06);
    padding:25px;
    border-radius:12px;
}

label{
    font-size:13px;
    color:#aaa;
}

input, select{
    width:100%;
    padding:10px;
    margin:10px 0 15px;
    border-radius:6px;
    border:none;
    outline:none;
}

.btn{
    background:#00f7ff;
    border:none;
    padding:10px 20px;
    font-weight:bold;
    border-radius:6px;
    cursor:pointer;
}

.btn:hover{
    box-shadow:0 0 15px #00f7ff;
}
</style>

</head>

<body>

<div class="main">

<h1>Add Trip</h1>

<div class="form-box">

<form method="POST">

    <!-- VEHICLE -->
    <label>Vehicle</label>
    <select name="vehicle_id" required>
        <option value="">-- Select Vehicle --</option>
        <?php while($v = mysqli_fetch_assoc($vehicles)) { ?>
            <option value="<?php echo $v['id']; ?>">
                <?php echo $v['vehicle_name']; ?>
            </option>
        <?php } ?>
    </select>

    <!-- DRIVER -->
    <label>Driver</label>
    <select name="driver" required>
        <option value="">-- Select Driver --</option>
        <?php while($d = mysqli_fetch_assoc($drivers)) { ?>
            <option value="<?php echo $d['username']; ?>">
                <?php echo $d['username']; ?>
            </option>
        <?php } ?>
    </select>

    <!-- STAFF (FIXED) -->
    <label>Staff</label>
    <select name="staff" required>
        <option value="">-- Select Staff --</option>
        <?php while($s = mysqli_fetch_assoc($staffs)) { ?>
            <option value="<?php echo $s['username']; ?>">
                <?php echo $s['username']; ?>
            </option>
        <?php } ?>
    </select>

    <!-- DESTINATION -->
    <label>Destination</label>
    <input type="text" name="destination" required>

    <!-- DATE -->
    <label>Date</label>
    <input type="date" name="trip_date" required>

    <button class="btn" type="submit" name="add_trip">
        Add Trip
    </button>

</form>

</div>

</div>

</body>
</html>