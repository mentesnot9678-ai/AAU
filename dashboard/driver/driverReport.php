<?php
session_start();
include("../../config/db.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] != "driver") {
    header("Location: ../../auth/login.php");
    exit();
}

$username = $_SESSION['user'] ?? '';

/* Fetch trips assigned to this driver */
$trips = mysqli_query($conn, "
    SELECT t.*, v.vehicle_name, v.plate_number
    FROM trips t
    LEFT JOIN vehicles v ON t.vehicle_id = v.id
    WHERE t.driver='$username'
    ORDER BY t.id DESC
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Trip Reports</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">

    <style>
        table{
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
        }

        th,td{
            padding:12px;
            border:1px solid #444;
            text-align:left;
        }

        th{
            background:#00f7ff;
            color:#000;
        }

        tr:nth-child(even){
            background:rgba(255,255,255,0.05);
        }

        .approved{
            color:lime;
            font-weight:bold;
        }

        .pending{
            color:orange;
            font-weight:bold;
        }

        .rejected{
            color:red;
            font-weight:bold;
        }

        .completed{
            color:#00f7ff;
            font-weight:bold;
        }
    </style>
</head>

<body>

<div class="sidebar">
    <h2>AAU VMS</h2>

    <a href="index.php">Dashboard</a>
   
    <a href="driverReport.php" class="active">Trip Reports</a>
    <a href="driver_comment.php">Write Comment</a>
    <a href="submit_service_request.php">Submit Service Request</a>
    
</div>

<div class="main">

    <h1>My Assigned Trips</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Vehicle</th>
            <th>Plate Number</th>
            <th>Driver</th>
            <th>Destination</th>
            <th>Trip Date</th>
            <th>Status</th>
        </tr>

        <?php if(mysqli_num_rows($trips) > 0): ?>

            <?php while($trip = mysqli_fetch_assoc($trips)): ?>

            <tr>
                <td><?php echo $trip['id']; ?></td>

                <td>
                    <?php echo htmlspecialchars($trip['vehicle_name'] ?? 'N/A'); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($trip['plate_number'] ?? 'N/A'); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($trip['driver']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($trip['destination']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($trip['trip_date']); ?>
                </td>

                <td>
                    <?php
                    $status = strtolower($trip['status']);

                    if($status == 'approved'){
                        echo "<span class='approved'>Approved</span>";
                    }
                    elseif($status == 'pending' || $status == 'pending staff approval'){
                        echo "<span class='pending'>Pending</span>";
                    }
                    elseif($status == 'rejected'){
                        echo "<span class='rejected'>Rejected</span>";
                    }
                    elseif($status == 'completed'){
                        echo "<span class='completed'>Completed</span>";
                    }
                    else{
                        echo htmlspecialchars($trip['status']);
                    }
                    ?>
                </td>
            </tr>

            <?php endwhile; ?>

        <?php else: ?>

            <tr>
                <td colspan="7" style="text-align:center;">
                    No trips assigned yet
                </td>
            </tr>

        <?php endif; ?>

    </table>

</div>

</body>
</html>