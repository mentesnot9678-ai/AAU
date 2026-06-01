<?php
session_start();
include("../../config/db.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] != "manager") {
    header("Location: ../../auth/login.php");
    exit();
}

/* ASSIGN VEHICLE */

if (isset($_POST['assign'])) {

    $trip_id = $_POST['trip_id'];
    $vehicle_id = $_POST['vehicle_id'];

    $sql = "UPDATE trips SET vehicle_id='$vehicle_id' WHERE id='$trip_id'";
    mysqli_query($conn, $sql);

    echo "<script>alert('Vehicle Assigned Successfully');</script>";

}

/* FETCH DATA */

$trips = mysqli_query($conn, "SELECT * FROM trips WHERE status='Approved'");
$vehicles = mysqli_query($conn, "SELECT * FROM vehicles");

?>

<!DOCTYPE html>
<html>

<head>

    <title>Assign Vehicle</title>

    <link rel="stylesheet" href="../../assets/css/dashboard.css">

    <style>
        body {
            background: #0f2027;
            color: white;
            font-family: Segoe UI;
        }

        .container {
            margin-left: 220px;
            padding: 40px;
        }

        .card {
            background: rgba(255, 255, 255, 0.05);
            padding: 30px;
            border-radius: 12px;
            backdrop-filter: blur(10px);
            box-shadow: 0 0 15px rgba(0, 247, 255, 0.2);
            max-width: 500px;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: none;
        }

        button {
            padding: 10px 20px;
            background: #00f7ff;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>

</head>

<body>

    <div class="sidebar">

        <h2>AAU VMS</h2>

        <a href="manager_dashboard.php">Dashboard</a>
        <a href="manage_requests.php">Trip Requests</a>
        <a href="assign_vehicle.php" class="active">Assign Vehicle</a>
        <a href="assign_driver.php">Assign Driver</a>
        <a href="manager_vehicles.php">Vehicles</a>
        <a href="fleet_map.php">Fleet Map</a>
        <a href="../../auth/logout.php">Logout</a>

    </div>

    <div class="container">

        <h1>Assign Vehicle to Trip</h1>

        <div class="card">

            <form method="post">

                <label>Select Trip</label>

                <select name="trip_id" required>

                    <?php while ($trip = mysqli_fetch_assoc($trips)): ?>

                        <option value="<?php echo $trip['id']; ?>">
                            Trip #
                            <?php echo $trip['id']; ?>
                        </option>

                    <?php endwhile; ?>

                </select>

                <label>Select Vehicle</label>

                <select name="vehicle_id" required>

                    <?php while ($vehicle = mysqli_fetch_assoc($vehicles)): ?>

                        <option value="<?php echo $vehicle['id']; ?>">
                            <?php echo $vehicle['plate_number']; ?>
                        </option>

                    <?php endwhile; ?>

                </select>

                <button name="assign">Assign Vehicle</button>

            </form>

        </div>

    </div>

</body>

</html>