<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../auth/login.php");
    exit();
}

$error = "";
if(isset($_POST['add_maintenance'])){
    $vehicle_id = $_POST['vehicle_id'];
    $service_type = $_POST['service_type'];
    $description = $_POST['description'];
    $service_date = $_POST['service_date'];
    $status = $_POST['status'];

    $sql = "INSERT INTO maintenance (vehicle_id, service_type, description, service_date, status)
            VALUES ('$vehicle_id','$service_type','$description','$service_date','$status')";

    if(mysqli_query($conn,$sql)){
        header("Location: maintenance.php"); // redirect after adding
        exit();
    } else {
        $error = "Error adding maintenance: " . mysqli_error($conn);
    }
}

// Fetch vehicles for dropdown
$vehicles = mysqli_query($conn,"SELECT * FROM vehicles");
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Maintenance</title>
<link rel="stylesheet" href="../assets/css/dashboard.css">
<style>
.main{padding:20px;}
form{max-width:500px;margin:auto;background: rgba(255,255,255,0.05);padding:20px;border-radius:10px;backdrop-filter:blur(10px);}
input, select, textarea{width:100%;padding:10px;margin:10px 0;border-radius:5px;border:none;}
button{background:#00f7ff;color:black;padding:12px 20px;border:none;font-weight:bold;border-radius:8px;cursor:pointer;transition:.3s;}
button:hover{box-shadow:0 0 20px #00f7ff;transform:translateY(-2px);}
.error{color:red;margin-bottom:10px;}
</style>
</head>
<body>

<div class="sidebar">
<h2>AAU VMS</h2>
<a href="admin.php">Dashboard</a>
<a href="manage_users.php">Users</a>
<a href="vehicles.php">Vehicles</a>
<a href="trips.php">Trips</a>
<a href="maintenance.php" class="active">Maintenance</a>
<a href="map.php">Vehicle Map</a>
<a href="../auth/logout.php">Logout</a>
</div>

<div class="main">
<h2>Add Maintenance Record</h2>

<?php if($error) echo "<div class='error'>$error</div>"; ?>

<form method="POST">
<label>Vehicle</label>
<select name="vehicle_id" required>
<option value="">--Select Vehicle--</option>
<?php while($v=mysqli_fetch_assoc($vehicles)){ ?>
<option value="<?php echo $v['id']; ?>"><?php echo $v['vehicle_name']." (".$v['plate_number'].")"; ?></option>
<?php } ?>
</select>

<label>Service Type</label>
<input type="text" name="service_type" placeholder="Oil Change, Repair, etc." required>

<label>Description</label>
<textarea name="description" placeholder="Describe the service..." required></textarea>

<label>Service Date</label>
<input type="date" name="service_date" required>

<label>Status</label>
<select name="status">
<option value="Pending">Pending</option>
<option value="In Progress">In Progress</option>
<option value="Completed">Completed</option>
</select>

<button type="submit" name="add_maintenance">Add Maintenance</button>
<p><a href="maintenance.php" style="color:#00f7ff">Back to Maintenance</a></p>
</form>
</div>

</body>
</html>