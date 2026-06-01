<?php
session_start();
include("../../config/db.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

/* Allow only manager */
if (!isset($_SESSION['role']) || $_SESSION['role'] != "manager") {
    header("Location: ../../auth/login.php");
    exit();
}

/* Assign Driver */
if (isset($_POST['assign'])) {

    $trip_id = $_POST['trip_id'];
    $driver_name = $_POST['driver_name'];

    mysqli_query($conn, "UPDATE trips SET driver='$driver_name' WHERE id='$trip_id'");

    echo "<script>alert('Driver Assigned Successfully');</script>";
}

/* Fetch trips */
$trips = mysqli_query($conn, "SELECT * FROM trips WHERE status='Approved'");

/* Fetch drivers */
$drivers = mysqli_query($conn, "SELECT * FROM users WHERE role='driver'");
?>

<!DOCTYPE html>
<html>

<head>

    <title>Assign Driver</title>
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
            max-width: 500px;
        }

        select,
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: none;
        }

        button {
            background: #00f7ff;
            font-weight: bold;
            cursor: pointer;
        }
    </style>

</head>

<body>

    <div class="sidebar">

        <h2>AAU VMS</h2>

        <a href="manager_dashboard.php">Dashboard</a>
        <a href="assign_driver.php" class="active">Assign Driver</a>
        <a href="../../auth/logout.php">Logout</a>

    </div>

    <div class="container">

        <h1>Assign Driver</h1>

        <div class="card">

            <form method="post">

                <label>Select Trip</label>
                <select name="trip_id" required>
                    <?php while ($t = mysqli_fetch_assoc($trips)): ?>
                        <option value="<?php echo $t['id']; ?>">
                            Trip #<?php echo $t['id']; ?> - <?php echo $t['destination']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <label>Select Driver</label>
                <select name="driver_name" required>

                    <?php while ($d = mysqli_fetch_assoc($drivers)):

                        /* SAFE COLUMN HANDLING */
                        $driverName = isset($d['name']) ? $d['name'] : (isset($d['username']) ? $d['username'] : 'Unknown');

                        ?>

                        <option value="<?php echo $driverName; ?>">
                            <?php echo $driverName; ?>
                        </option>

                    <?php endwhile; ?>

                </select>

                <button name="assign">Assign Driver</button>

            </form>

        </div>

    </div>

</body>

</html>