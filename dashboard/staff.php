<?php
session_start();
include("../config/db.php");

// Only staff allowed
if (!isset($_SESSION['role']) || $_SESSION['role'] != "staff") {
    header("Location: ../auth/login.php");
    exit();
}

$username = $_SESSION['user'] ?? $_SESSION['username'] ?? 'Staff';

// Get staff trips (if you use driver column as requester)
$trips = mysqli_query($conn, "
    SELECT *
    FROM trips
    WHERE driver='$username'
    ORDER BY id DESC
    LIMIT 5
");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Staff Dashboard</title>

    <link rel="stylesheet" href="../assets/css/dashboard.css">

    <style>

        body{
            margin:0;
            font-family:Arial;
            background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
            color:white;
        }

        .sidebar{
            width:220px;
            height:100vh;
            position:fixed;
            background:rgba(0,0,0,0.4);
            padding:20px;
        }

        .sidebar h2{
            color:#00f7ff;
            margin-bottom:20px;
        }

        .sidebar a{
            display:block;
            color:white;
            text-decoration:none;
            padding:10px;
            margin:5px 0;
            border-radius:6px;
        }

        .sidebar a:hover{
            background:#00f7ff;
            color:black;
        }

        .main{
            margin-left:240px;
            padding:30px;
        }

        .card{
            background:rgba(255,255,255,0.05);
            padding:20px;
            border-radius:12px;
            margin-bottom:20px;
            border:1px solid rgba(255,255,255,0.1);
        }

        .btn{
            padding:10px 15px;
            background:#00f7ff;
            border:none;
            border-radius:6px;
            cursor:pointer;
            font-weight:bold;
            text-decoration:none;
            display:inline-block;
            color:black;
        }

        .btn:hover{
            background:#00d4dd;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
        }

        th,td{
            padding:10px;
            border:1px solid #444;
            text-align:left;
        }

        th{
            background:#00f7ff;
            color:black;
        }

        .status{
            padding:5px 10px;
            border-radius:5px;
        }

        .pending{color:orange;}
        .approved{color:#00f7ff;}
        .rejected{color:red;}

    </style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <h2>STAFF PANEL</h2>

    <a href="staff.php">Dashboard</a>

    <a href="staff_request_trip.php">Request Trip</a>
    
    <a href="staff_comment.php">Send Message</a>

    <a href="../auth/logout.php">Logout</a>

</div>

<!-- MAIN -->
<div class="main">

    <div class="card">

        <h1>Welcome, <?php echo htmlspecialchars($username); ?></h1>

        <p>You are logged in as <b>Staff</b></p>

        <a class="btn" href="staff_request_trip.php">
            + Request New Trip
        </a>

    </div>

    <div class="card">

        <h2>My Recent Trip Requests</h2>

        <table>

            <tr>
                <th>ID</th>
                <th>Destination</th>
                <th>Date</th>
                <th>Status</th>
            </tr>

            <?php while($t = mysqli_fetch_assoc($trips)): ?>

            <tr>

                <td><?php echo $t['id']; ?></td>

                <td><?php echo $t['destination']; ?></td>

                <td><?php echo $t['trip_date']; ?></td>

                <td>

                    <?php if($t['status'] == 'Pending'): ?>
                        <span class="status pending">Pending</span>

                    <?php elseif($t['status'] == 'Approved'): ?>
                        <span class="status approved">Approved</span>

                    <?php elseif($t['status'] == 'Rejected'): ?>
                        <span class="status rejected">Rejected</span>

                    <?php else: ?>
                        <?php echo $t['status']; ?>
                    <?php endif; ?>

                </td>

            </tr>

            <?php endwhile; ?>

        </table>

    </div>

</div>

</body>
</html>