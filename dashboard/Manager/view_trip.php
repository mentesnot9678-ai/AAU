<?php
session_start();
require_once __DIR__ . '/../../config/db.php';

// Only manager allowed
if (!isset($_SESSION['role']) || $_SESSION['role'] != "manager") {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$id = (int) $_GET['id'];

// Fetch single trip
$query = mysqli_query($conn, "
    SELECT trips.*, vehicles.vehicle_name, vehicles.plate_number
    FROM trips
    LEFT JOIN vehicles ON trips.vehicle_id = vehicles.id
    WHERE trips.id = $id
");

$trip = mysqli_fetch_assoc($query);

if (!$trip) {
    die("Trip not found");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Trip</title>

    <link rel="stylesheet" href="../assets/css/dashboard.css">

    <style>
        body {
            background: linear-gradient(120deg, #0f2027, #203a43, #2c5364);
            color: white;
            font-family: 'Segoe UI';
            padding: 40px;
        }

        .card {
            max-width: 600px;
            margin: auto;
            background: rgba(255,255,255,0.05);
            padding: 25px;
            border-radius: 12px;
            backdrop-filter: blur(10px);
            box-shadow: 0 0 20px rgba(0,247,255,0.2);
        }

        h2 {
            color: #00f7ff;
            text-align: center;
            margin-bottom: 20px;
        }

        .row {
            margin-bottom: 12px;
        }

        .label {
            color: #00f7ff;
            font-weight: bold;
        }

        a.back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background: #00f7ff;
            color: black;
            text-decoration: none;
            border-radius: 6px;
        }

        a.back:hover {
            box-shadow: 0 0 15px #00f7ff;
        }
    </style>
</head>

<body>

<div class="card">

    <h2>Trip Details</h2>

    <div class="row"><span class="label">Trip ID:</span> <?php echo $trip['id']; ?></div>

    <div class="row"><span class="label">Vehicle:</span> 
        <?php echo $trip['vehicle_name']; ?> (<?php echo $trip['plate_number']; ?>)
    </div>

    <div class="row"><span class="label">Driver:</span> <?php echo $trip['driver']; ?></div>

    <div class="row"><span class="label">Destination:</span> <?php echo $trip['destination']; ?></div>

    <div class="row"><span class="label">Trip Date:</span> <?php echo $trip['trip_date']; ?></div>

    <div class="row"><span class="label">Status:</span> <?php echo $trip['status']; ?></div>

    <a href="trips.php" class="back">← Back</a>

</div>

</body>
</html>