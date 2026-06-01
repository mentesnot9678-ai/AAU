<?php
session_start();
include("../../config/db.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] != "manager") {
    header("Location: ../../auth/login.php");
    exit();
}

/* =========================
   FETCH ALL TRIPS
========================= */
$result = mysqli_query($conn, "
    SELECT t.id, t.vehicle_id, t.driver, t.staff, t.destination, t.trip_date, t.status,
           v.vehicle_name, v.plate_number
    FROM trips t
    LEFT JOIN vehicles v ON t.vehicle_id = v.id
    ORDER BY t.id DESC
");

/* =========================
   FORCE DOWNLOAD AS EXCEL
========================= */
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=trips_report.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Vehicle</th>
        <th>Plate Number</th>
        <th>Driver</th>
        <th>Staff</th>
        <th>Destination</th>
        <th>Date</th>
        <th>Status</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['vehicle_name']; ?></td>
            <td><?php echo $row['plate_number']; ?></td>
            <td><?php echo $row['driver']; ?></td>
            <td><?php echo $row['staff']; ?></td>
            <td><?php echo $row['destination']; ?></td>
            <td><?php echo $row['trip_date']; ?></td>
            <td><?php echo $row['status']; ?></td>
        </tr>
    <?php } ?>
</table>