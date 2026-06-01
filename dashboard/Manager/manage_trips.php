<?php
session_start();

// FIXED PATH
require_once __DIR__ . '/../../config/db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != "manager"){
    header("Location: ../auth/login.php");
    exit();
}

// Approve / Reject
if(isset($_GET['approve'])){
    $id = (int) $_GET['approve'];
    mysqli_query($conn, "UPDATE trips SET status='Approved' WHERE id=$id");
    header("Location: manage_trips.php");
    exit();
}

if(isset($_GET['reject'])){
    $id = (int) $_GET['reject'];
    mysqli_query($conn, "UPDATE trips SET status='Rejected' WHERE id=$id");
    header("Location: manage_trips.php");
    exit();
}

$result = mysqli_query(
    $conn,
    "SELECT trips.*, vehicles.vehicle_name 
     FROM trips 
     LEFT JOIN vehicles ON trips.vehicle_id = vehicles.id
     ORDER BY trips.created_at DESC"
);

if(!$result){
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Trips</title>
<link rel="stylesheet" href="../assets/css/dashboard.css">

<style>
select {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 8px;
    outline: none;

    background: rgba(255, 255, 255, 0.08); /* your style */
    color: #000000; /* BLACK TEXT */

    font-size: 14px;
}

/* dropdown options */
select option {
    background: #ffffff; /* white dropdown list */
    color: #000000;     /* black text */
}

/* optional: focus effect */
select:focus {
    border: 1px solid #00f7ff;
    box-shadow: 0 0 10px rgba(0, 247, 255, 0.5);
}
</style>

</head>
<body>

<div class="main">
<h2>Manage Trips</h2>

<table border="1" cellspacing="0" cellpadding="10">
<tr>
<th>Driver</th>
<th>Vehicle</th>
<th>Destination</th>
<th>Date</th>
<th>Status</th>
<th>Actions</th>
</tr>

<?php while($t = mysqli_fetch_assoc($result)): ?>
<tr>
<td><?php echo $t['driver']; ?></td>
<td><?php echo $t['vehicle_name']; ?></td>
<td><?php echo $t['destination']; ?></td>
<td><?php echo $t['trip_date']; ?></td>

<td>
<span class="status <?php echo strtolower($t['status']); ?>">
    <?php echo $t['status']; ?>
</span>
</td>

<td>
<?php if($t['status'] == "Pending"): ?>
    <a href="?approve=<?php echo $t['id']; ?>">Approve</a> | 
    <a href="?reject=<?php echo $t['id']; ?>">Reject</a>
<?php else: ?>
    N/A
<?php endif; ?>
</td>

</tr>
<?php endwhile; ?>

</table>

</div>

</body>
</html>