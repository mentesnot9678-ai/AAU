<?php
session_start();

require_once __DIR__ . '/../../config/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != "manager") {
    header("Location: ../auth/login.php");
    exit();
}

/* =========================
   FETCH TRIPS
========================= */
$result = mysqli_query($conn, "
    SELECT trips.*, vehicles.vehicle_name 
    FROM trips 
    LEFT JOIN vehicles ON trips.vehicle_id = vehicles.id
    ORDER BY trips.id DESC
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Trips - Manager</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">

    <style>
        body {
            background: linear-gradient(120deg, #0f2027, #203a43, #2c5364);
            color: white;
            font-family: 'Segoe UI';
            margin: 0;
        }

        .main {
            margin-left: 250px;
            padding: 20px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .topbar h1 {
            color: #00f7ff;
        }

        .add-btn {
            padding: 10px 18px;
            background: #00f7ff;
            color: black;
            font-weight: bold;
            border-radius: 8px;
            text-decoration: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background: rgba(255,255,255,0.05);
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: left;
        }

        th {
            background: rgba(0,0,0,0.6);
            color: #00f7ff;
        }

        tr:hover {
            background: rgba(0,247,255,0.08);
        }

        .action-btn {
            padding: 6px 10px;
            border-radius: 6px;
            text-decoration: none;
            margin-right: 5px;
            font-size: 13px;
        }

        .view-btn {
            background: #00f7ff;
            color: black;
        }

        .edit-btn {
            background: #facc15;
            color: black;
        }

        .delete-btn {
            background: #ef4444;
            color: white;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100%;
            background: rgba(0,0,0,0.6);
            padding-top: 20px;
        }

        .sidebar h2 {
            color: #00f7ff;
            text-align: center;
        }

        .sidebar a {
            display: block;
            padding: 12px;
            color: white;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #00f7ff;
            color: black;
        }
    </style>
</head>

<body>

<div class="sidebar">
    <h2>AAU VMS</h2>
    <a href="manager_dashboard.php">Dashboard</a>
    <a href="trips.php" class="active">Trips</a>
</div>

<div class="main">

    <div class="topbar">
        <h1>Trip Management</h1>
        <a href="add_trip.php" class="add-btn">Add Trip</a>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Vehicle</th>
            <th>Driver</th>
            <th>Destination</th>
            <th>Trip Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php while ($t = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $t['id']; ?></td>
                <td><?php echo htmlspecialchars($t['vehicle_name'] ?? 'Not Assigned'); ?></td>
                <td><?php echo htmlspecialchars($t['driver']); ?></td>
                <td><?php echo htmlspecialchars($t['destination']); ?></td>
                <td><?php echo htmlspecialchars($t['trip_date']); ?></td>

                <td>
                    <?php
                    if ($t['status'] == 'Pending Staff Approval') {
                        echo "<span style='color:orange;'>Pending</span>";
                    } elseif ($t['status'] == 'Approved') {
                        echo "<span style='color:lime;'>Approved</span>";
                    } elseif ($t['status'] == 'Rejected') {
                        echo "<span style='color:red;'>Rejected</span>";
                    } else {
                        echo htmlspecialchars($t['status']);
                    }
                    ?>
                </td>

                <td>
                    <a href="view_trip.php?id=<?php echo $t['id']; ?>" class="action-btn view-btn">View</a>
                    <a href="edit_trip.php?id=<?php echo $t['id']; ?>" class="action-btn edit-btn">Edit</a>
                    <a href="delete_trip.php?id=<?php echo $t['id']; ?>" class="action-btn delete-btn"
                       onclick="return confirm('Are you sure?');">
                       Delete
                    </a>
                </td>
            </tr>
        <?php } ?>

    </table>

</div>

</body>
</html>