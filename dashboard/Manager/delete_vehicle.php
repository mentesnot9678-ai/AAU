<?php
include("../../config/db.php");

$id = $_POST['id'];

// Prevent deleting vehicle if in use
$check = mysqli_query($conn, "
    SELECT * FROM trips 
    WHERE vehicle_id='$id' AND status='On Trip'
");

if (mysqli_num_rows($check) > 0) {
    echo "<script>alert('Cannot delete: Vehicle is in use'); window.history.back();</script>";
    exit();
}

mysqli_query($conn, "DELETE FROM vehicles WHERE id='$id'");

header("Location: manager_vehicles.php");