<?php
session_start();
include("../config/db.php");

// Only admin can access
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../auth/login.php");
    exit();
}

// Check if ID is provided
if(!isset($_GET['id'])){
    header("Location: vehicles.php");
    exit();
}

$id = $_GET['id'];

// Fetch current vehicle data
$result = mysqli_query($conn, "SELECT * FROM vehicles WHERE id=$id");
if(mysqli_num_rows($result) != 1){
    header("Location: vehicles.php");
    exit();
}

$vehicle = mysqli_fetch_assoc($result);

// Handle form submission
if(isset($_POST['update'])){
    $name = $_POST['vehicle_name'];
    $plate = $_POST['plate_number'];
    $driver = $_POST['driver'];
    $status = $_POST['status'];
    $service = $_POST['service'];
    $service_date = $_POST['service_date'];
    $location = $_POST['location'];

    $sql = "UPDATE vehicles SET 
            vehicle_name='$name', 
            plate_number='$plate', 
            driver='$driver', 
            status='$status', 
            service='$service', 
            service_date='$service_date', 
            location='$location' 
            WHERE id=$id";

    if(mysqli_query($conn, $sql)){
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
<title>Edit Vehicle - Admin</title>
<link rel="stylesheet" href="../assets/css/dashboard.css">
<style>
body { background: linear-gradient(120deg,#0f2027,#203a43,#2c5364); color:white; font-family:'Segoe UI'; }
.main { margin-left:250px; padding:20px; }
form { background: rgba(0,0,0,0.5); padding:20px; border-radius:10px; max-width:600px; margin:auto; }
input, select, textarea { width:100%; padding:10px; margin:10px 0; border-radius:6px; border:none; }
textarea { resize:vertical; height:80px; }
button { padding:10px 20px; background:#facc15; color:black; border:none; border-radius:6px; cursor:pointer; }
button:hover { box-shadow:0 0 15px #facc15; transform:translateY(-2px); }
.back-btn { background:#ef4444; color:white; text-decoration:none; padding:10px 20px; border-radius:6px; margin-right:10px; display:inline-block; }
.back-btn:hover { box-shadow:0 0 15px #ef4444; transform:translateY(-2px); }
.error { color:#ff4d4d; margin-bottom:15px; }
</style>
</head>
<body>

<div class="main">
<h1>Edit Vehicle</h1>

<?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

<form method="POST">
    <label>Vehicle Name</label>
    <input type="text" name="vehicle_name" value="<?php echo htmlspecialchars($vehicle['vehicle_name']); ?>" required>

    <label>Plate Number</label>
    <input type="text" name="plate_number" value="<?php echo htmlspecialchars($vehicle['plate_number']); ?>" required>

    <label>Driver</label>
    <input type="text" name="driver" value="<?php echo htmlspecialchars($vehicle['driver']); ?>">

    <label>Status</label>
    <select name="status">
        <option value="Active" <?php if($vehicle['status']=='Active') echo 'selected'; ?>>Active</option>
        <option value="Inactive" <?php if($vehicle['status']=='Inactive') echo 'selected'; ?>>Inactive</option>
    </select>

    <label>Service / Description</label>
    <textarea name="service"><?php echo htmlspecialchars($vehicle['service']); ?></textarea>

    <label>Date of Last Service</label>
    <input type="date" name="service_date" value="<?php echo $vehicle['service_date']; ?>">

    <label>Vehicle Location (Map / Coordinates)</label>
    <input type="text" name="location" value="<?php echo htmlspecialchars($vehicle['location']); ?>">

    <div style="margin-top:15px;">
        <a href="vehicles.php" class="back-btn">Back</a>
        <button type="submit" name="update">Update Vehicle</button>
    </div>
</form>
</div>

</body>
</html>