<?php
session_start();
include("../../config/db.php");

/* =========================
   AUTH CHECK
========================= */
if (!isset($_SESSION['role']) || $_SESSION['role'] != "manager") {
    header("Location: ../../auth/login.php");
    exit();
}

/* =========================
   FETCH VEHICLES + STATUS
========================= */
$vehicles = mysqli_query($conn, "
    SELECT v.*, 
    (
        SELECT COUNT(*) FROM trips t 
        WHERE t.vehicle_id = v.id AND t.status = 'On Trip'
    ) as busy
    FROM vehicles v
    ORDER BY v.id DESC
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manager - Vehicles</title>

    <style>
        body {
            background: #0f2027;
            color: white;
            font-family: Segoe UI;
        }

        .sidebar {
            width: 220px;
            height: 100vh;
            position: fixed;
            background: #111;
            padding: 20px;
        }

        .sidebar a {
            display: block;
            color: white;
            margin: 10px 0;
            text-decoration: none;
        }

        .sidebar a.active {
            background: #00f7ff;
            color: black;
            padding: 6px;
            border-radius: 6px;
        }

        .container {
            margin-left: 240px;
            padding: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            overflow: hidden;
        }

        th,
        td {
            padding: 12px;
            text-align: center;
        }

        th {
            background: #00f7ff;
            color: black;
        }

        tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.05);
        }

        tr:hover {
            background: rgba(0, 247, 255, 0.1);
        }

        .status-available {
            color: #2ecc71;
            font-weight: bold;
        }

        .status-busy {
            color: #e74c3c;
            font-weight: bold;
        }

        .btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .delete {
            background: #e74c3c;
            color: white;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>AAU VMS</h2>

        <a href="manager_dashboard.php">Dashboard</a>
        <a href="assign_driver.php">Assign Driver</a>
        <a href="assign_vehicle.php">Assign Vehicle</a>
        <a href="manager_vehicles.php" class="active">Vehicles</a>

        <hr style="border:0.5px solid #444; margin:15px 0;">

        <a href="../../auth/logout.php">Logout</a>
    </div>

    <!-- MAIN -->
    <div class="container">

        <h1 style="color:#00f7ff;">Fleet Vehicles</h1>

        <table>
            <tr>
                <th>ID</th>
                <th>Vehicle Name</th>
                <th>Plate Number</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php if (mysqli_num_rows($vehicles) == 0): ?>

                <tr>
                    <td colspan="5">No vehicles found</td>
                </tr>

            <?php else: ?>

                <?php while ($v = mysqli_fetch_assoc($vehicles)) { ?>

                    <tr>
                        <td><?php echo $v['id']; ?></td>

                        <td><?php echo htmlspecialchars($v['vehicle_name']); ?></td>

                        <td><?php echo htmlspecialchars($v['plate_number']); ?></td>

                        <td>
                            <?php if ($v['busy'] > 0): ?>
                                <span class="status-busy">Busy</span>
                            <?php else: ?>
                                <span class="status-available">Available</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <form method="post" action="delete_vehicle.php" onsubmit="return confirm('Delete this vehicle?');">
                                <input type="hidden" name="id" value="<?php echo $v['id']; ?>">
                                <button class="btn delete">Delete</button>
                            </form>
                        </td>

                    </tr>

                <?php } ?>

            <?php endif; ?>

        </table>

    </div>

</body>

</html>