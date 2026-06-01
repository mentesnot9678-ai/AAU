<?php
session_start();

require_once __DIR__ . '/../../config/db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != "manager"){
    header("Location: ../../auth/login.php");
    exit();
}

$maintenance = mysqli_query($conn,"
    SELECT
        m.*,
        v.vehicle_name,
        v.plate_number
    FROM maintenance m
    LEFT JOIN vehicles v ON m.vehicle_id = v.id
    ORDER BY m.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Maintenance Requests</title>

<link rel="stylesheet" href="../assets/css/dashboard.css">

<style>

body{
    background:linear-gradient(120deg,#0f2027,#203a43,#2c5364);
    color:white;
    font-family:'Segoe UI';
}

.main{
    margin-left:250px;
    padding:20px;
}

table{
    width:100%;
    border-collapse:collapse;
    background:rgba(255,255,255,0.05);
    backdrop-filter:blur(10px);
}

th,td{
    padding:12px;
    border:1px solid rgba(255,255,255,0.1);
    text-align:left;
}

th{
    background:#00f7ff;
    color:black;
}

.pending{
    color:orange;
    font-weight:bold;
}

.progress{
    color:#00f7ff;
    font-weight:bold;
}

.completed{
    color:lime;
    font-weight:bold;
}

.sidebar{
    position:fixed;
    left:0;
    top:0;
    width:250px;
    height:100%;
    background:rgba(0,0,0,0.5);
    backdrop-filter:blur(10px);
    padding-top:20px;
}

.sidebar h2{
    color:#00f7ff;
    text-align:center;
}

.sidebar a{
    display:block;
    padding:12px 20px;
    color:white;
    text-decoration:none;
}

.sidebar a:hover,
.sidebar a.active{
    background:#00f7ff;
    color:black;
}

</style>

</head>
<body>

<div class="sidebar">

    <h2>AAU VMS</h2>

    <a href="manager_dashboard.php">Dashboard</a>
    <a href="manager_view_comments.php">Driver Messages</a>
    <a href="manager_view_staff_comments.php">Staff Messages</a>
    <a href="trips.php">Manage Trips</a>
    <a href="manager_view_maintenance.php" class="active">
        Maintenance Requests
    </a>
    <a href="manager_vehicles.php">Vehicles</a>
    <a href="../auth/logout.php">Logout</a>

</div>

<div class="main">

    <h1>Maintenance Requests</h1>

    <table>

        <tr>
            <th>ID</th>
            <th>Vehicle</th>
            <th>Plate Number</th>
            <th>Service Type</th>
            <th>Description</th>
            <th>Service Date</th>
            <th>Status</th>
        </tr>

        <?php while($m = mysqli_fetch_assoc($maintenance)){ ?>

        <tr>

            <td><?php echo $m['id']; ?></td>

            <td><?php echo htmlspecialchars($m['vehicle_name']); ?></td>

            <td><?php echo htmlspecialchars($m['plate_number']); ?></td>

            <td><?php echo htmlspecialchars($m['service_type']); ?></td>

            <td><?php echo htmlspecialchars($m['description']); ?></td>

            <td><?php echo $m['service_date']; ?></td>

            <td>

                <?php if($m['status']=="Pending"){ ?>
                    <span class="pending">Pending</span>

                <?php } elseif($m['status']=="In Progress"){ ?>
                    <span class="progress">In Progress</span>

                <?php } elseif($m['status']=="Completed"){ ?>
                    <span class="completed">Completed</span>

                <?php } else { ?>
                    <?php echo $m['status']; ?>
                <?php } ?>

            </td>

        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>