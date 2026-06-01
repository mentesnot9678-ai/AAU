<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != "driver"){
    header("Location: ../auth/login.php");
    exit();
}

$username = $_SESSION['user'];
$error = "";
$success = "";

if(isset($_POST['request_trip'])){
    $vehicle_id = $_POST['vehicle_id'];
    $destination = $_POST['destination'];
    $trip_date = $_POST['trip_date'];

    $sql = "INSERT INTO trips (vehicle_id, driver, destination, trip_date, status)
            VALUES ('$vehicle_id','$username','$destination','$trip_date','Pending')";
    
    if(mysqli_query($conn,$sql)){
        $success = "Trip requested successfully!";
    }else{
        $error = "Error: ".mysqli_error($conn);
    }
}

// Fetch all vehicles
$vehicles = mysqli_query($conn,"SELECT * FROM vehicles");
?>

<!DOCTYPE html>
<html>
<head>
<title>Request Trip</title>
<link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
<div class="main">
<h2>Request a New Trip</h2>

<?php if($error) echo "<p style='color:red'>$error</p>"; ?>
<?php if($success) echo "<p style='color:green'>$success</p>"; ?>

<form method="POST">
<label>Vehicle</label>
<select name="vehicle_id" required>
<option value="">Select Vehicle</option>
<?php while($v = mysqli_fetch_assoc($vehicles)): ?>
<option value="<?php echo $v['id']; ?>"><?php echo $v['vehicle_name']." (".$v['plate_number'].")"; ?></option>
<?php endwhile; ?>
</select>

<label>Destination</label>
<input type="text" name="destination" required>

<label>Trip Date</label>
<input type="date" name="trip_date" required>

<button type="submit" name="request_trip">Request Trip</button>
</form>
</div>
</body>
</html>