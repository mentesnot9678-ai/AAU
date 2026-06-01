<?php
session_start();

// FIXED PATH (IMPORTANT)
require_once __DIR__ . '/../../config/db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != "manager"){
    header("Location: ../auth/login.php");
    exit();
}

if(!isset($_GET['id'])){
    header("Location: trips.php");
    exit();
}

$id = (int) $_GET['id'];

$trip = mysqli_query($conn, "SELECT * FROM trips WHERE id=$id");
$data = mysqli_fetch_assoc($trip);

$vehicles = mysqli_query($conn, "SELECT * FROM vehicles");

if(isset($_POST['update_trip'])){

$vehicle_id=$_POST['vehicle_id'];
$driver=$_POST['driver'];
$destination=$_POST['destination'];
$trip_date=$_POST['trip_date'];
$status=$_POST['status'];

mysqli_query($conn,"UPDATE trips SET
vehicle_id='$vehicle_id',
driver='$driver',
destination='$destination',
trip_date='$trip_date',
status='$status'
WHERE id=$id");

header("Location: trips.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Trip</title>
<link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>

<div class="sidebar">

<h2>AAU VMS</h2>

<a href="manager_dashboard.php">Dashboard</a>
<a href="manager_view_comments.php">Driver Messages</a>
<a href="manager_view_staff_comments.php">Staff Messages</a>
<a href="trips.php" class="active">Trips</a>
</div>

<div class="main" style="margin-left:250px;padding:30px;color:white;">

<h1>Edit Trip</h1>

<form method="POST" style="max-width:500px;">

<label>Vehicle</label>

<select name="vehicle_id">

<?php while($v=mysqli_fetch_assoc($vehicles)){ ?>

<option value="<?php echo $v['id']; ?>"
<?php if($data['vehicle_id']==$v['id']) echo "selected"; ?>>

<?php echo $v['vehicle_name']; ?>

</option>

<?php } ?>

</select>

<br><br>

<label>Driver</label>
<input type="text" name="driver" value="<?php echo $data['driver']; ?>">

<br><br>

<label>Destination</label>
<input type="text" name="destination" value="<?php echo $data['destination']; ?>">

<br><br>

<label>Date</label>
<input type="date" name="trip_date" value="<?php echo $data['trip_date']; ?>">

<br><br>

<label>Status</label>

<select name="status">

<option <?php if($data['status']=="Pending") echo "selected"; ?>>Pending</option>
<option <?php if($data['status']=="Approved") echo "selected"; ?>>Approved</option>
<option <?php if($data['status']=="Completed") echo "selected"; ?>>Completed</option>
<option <?php if($data['status']=="Completed") echo "selected"; ?>>Rejected</option>


</select>

<br><br>

<button name="update_trip">Update Trip</button>

</form>

</div>

</body>
</html>

<style>
body {
    margin: 0;
    font-family: "Segoe UI", Arial, sans-serif;
    background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
    color: white;
}

/* ================= SIDEBAR ================= */
.sidebar {
    position: fixed;
    left: 0;
    top: 0;
    width: 250px;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(12px);
    padding-top: 20px;
}

.sidebar h2 {
    color: #00f7ff;
    text-align: center;
    margin-bottom: 30px;
    text-shadow: 0 0 10px #00f7ff;
}

.sidebar a {
    display: block;
    color: white;
    padding: 12px 20px;
    text-decoration: none;
    margin: 5px 10px;
    border-radius: 8px;
    transition: 0.3s;
}

.sidebar a:hover,
.sidebar a.active {
    background: #00f7ff;
    color: black;
    box-shadow: 0 0 15px #00f7ff;
}

/* ================= MAIN AREA ================= */
.main {
    margin-left: 260px;
    padding: 40px;
}

/* ================= HEADINGS ================= */
h1 {
    color: #00f7ff;
    text-shadow: 0 0 10px #00f7ff;
    margin-bottom: 25px;
}

/* ================= FORM BOX ================= */
form {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(12px);
    padding: 30px;
    border-radius: 15px;
    max-width: 500px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 0 25px rgba(0, 247, 255, 0.1);
}

/* ================= LABELS ================= */
label {
    display: block;
    margin-top: 15px;
    margin-bottom: 5px;
    font-weight: bold;
    color: #00f7ff;
}

/* ================= INPUTS ================= */
input,
select,
textarea {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 8px;
    outline: none;

    background: rgba(0, 0, 0, 0.25);  /* FIXED VISIBILITY */
    color: #ffffff;                  /* WHITE TEXT */
    font-size: 14px;
}

/* PLACEHOLDER */
input::placeholder,
textarea::placeholder {
    color: rgba(255,255,255,0.6);
}

/* FOCUS EFFECT */
input:focus,
select:focus,
textarea:focus {
    box-shadow: 0 0 10px #00f7ff;
    border: 1px solid #00f7ff;
}

/* ================= BUTTON ================= */
button {
    margin-top: 20px;
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 8px;
    background: #00f7ff;
    color: black;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    box-shadow: 0 0 20px #00f7ff;
    transform: translateY(-2px);
}

/* ================= SELECT FIX ================= */
select {
    color: #ffffff;
}

select option {
    background: #111827;
    color: #ffffff;
}
</style>