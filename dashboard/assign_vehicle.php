<?php
session_start();
include("../../config/db.php");

if ($_SESSION['role'] != "admin") {
    header("Location: ../../index.php");
}

$vehicles = mysqli_query($conn, "SELECT * FROM vehicles WHERE status='available'");
$drivers = mysqli_query($conn, "SELECT * FROM users WHERE role='user'");

if (isset($_POST['assign'])) {

    $vehicle_id = $_POST['vehicle_id'];
    $driver_id = $_POST['driver_id'];
    $admin_id = $_SESSION['user_id'];

    mysqli_query($conn, "INSERT INTO vehicle_assignments(vehicle_id,driver_id,assigned_by) 
    VALUES('$vehicle_id','$driver_id','$admin_id')");

    mysqli_query($conn, "UPDATE vehicles SET status='assigned' WHERE id='$vehicle_id'");

    echo "<script>alert('Vehicle Assigned Successfully')</script>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Assign Vehicle</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
        }

        .container {
            width: 500px;
            margin: auto;
            margin-top: 80px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }

        select,
        button {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
        }

        button {
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>

    <div class="container">

        <h2>Assign Vehicle</h2>

        <form method="POST">

            <label>Select Vehicle</label>

            <select name="vehicle_id" required>

                <?php
                while ($v = mysqli_fetch_assoc($vehicles)) {
                    echo "<option value='" . $v['id'] . "'>" . $v['vehicle_number'] . "</option>";
                }
                ?>

            </select>


            <label>Select Driver</label>

            <select name="driver_id" required>

                <?php
                while ($d = mysqli_fetch_assoc($drivers)) {
                    echo "<option value='" . $d['id'] . "'>" . $d['username'] . "</option>";
                }
                ?>

            </select>

            <button type="submit" name="assign">Assign Vehicle</button>

        </form>

    </div>

</body>

</html>