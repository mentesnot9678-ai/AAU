<?php
session_start();
include("../../config/db.php");

// Only allow drivers
if (!isset($_SESSION['role']) || $_SESSION['role'] != "driver") {
    header("Location: ../../auth/login.php");
    exit();
}

$username = $_SESSION['user'];
$success = "";
$error = "";

// Get driver ID
$user_q = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");
$user = mysqli_fetch_assoc($user_q);

if (!$user) {
    die("Driver account not found.");
}

$driver_id = $user['id'];

// Submit service request
if (isset($_POST['submit'])) {

    $issue = mysqli_real_escape_string($conn, trim($_POST['issue']));

    if (!empty($issue)) {

        $insert = mysqli_query(
            $conn,
            "INSERT INTO service_requests
            (driver_id, issue, status)
            VALUES
            ('$driver_id', '$issue', 'Pending Admin Approval')"
        );

        if ($insert) {
            $success = "Service request submitted successfully and sent to admin.";
        } else {
            $error = mysqli_error($conn);
        }
    }
}

// Fetch driver's requests
$requests = mysqli_query(
    $conn,
    "SELECT id, issue, status, created_at
     FROM service_requests
     WHERE driver_id='$driver_id'
     ORDER BY created_at DESC"
);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Submit Service Request</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">

    <style>
        table{
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
        }

        th,td{
            padding:12px;
            border:1px solid #555;
            text-align:left;
        }

        .pending{
            color:orange;
            font-weight:bold;
        }

        .mechanic{
            color:#00f7ff;
            font-weight:bold;
        }

        .progress{
            color:#00ff66;
            font-weight:bold;
        }

        .completed{
            color:#9cff00;
            font-weight:bold;
        }

        .rejected{
            color:red;
            font-weight:bold;
        }
    </style>
</head>

<body>

<div class="sidebar">
    <h2>AAU VMS</h2>

    <a href="index.php">Dashboard</a>
    <a href="profile.php">Profile</a>
    <a href="driverReport.php">Trip Reports</a>
    <a href="submit_service_request.php" class="active">
        Submit Service Request
    </a>
    <a href="map.php">Vehicle Map</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main">

    <h1>Submit Service Request</h1>

    <?php if ($success != "") : ?>
        <p style="color:lime;font-weight:bold;">
            <?php echo $success; ?>
        </p>
    <?php endif; ?>

    <?php if ($error != "") : ?>
        <p style="color:red;font-weight:bold;">
            <?php echo $error; ?>
        </p>
    <?php endif; ?>

    <form method="post">

        <label>Issue / Service Request</label>
        <br><br>

        <textarea
            name="issue"
            required
            placeholder="Describe the vehicle issue..."
            style="width:100%;height:120px;padding:10px;"></textarea>

        <br><br>

        <button type="submit" name="submit">
            Submit Request
        </button>

    </form>

    <h2 style="margin-top:40px;">Your Previous Requests</h2>

    <table>

        <tr>
            <th>ID</th>
            <th>Issue</th>
            <th>Status</th>
            <th>Submitted At</th>
        </tr>

        <?php while ($r = mysqli_fetch_assoc($requests)) : ?>

            <tr>

                <td><?php echo $r['id']; ?></td>

                <td><?php echo htmlspecialchars($r['issue']); ?></td>

                <td>

                    <?php
                    if ($r['status'] == 'Pending Admin Approval') {
                        echo '<span class="pending">Pending Admin Approval</span>';
                    } elseif ($r['status'] == 'Sent to Mechanic') {
                        echo '<span class="mechanic">Sent to Mechanic</span>';
                    } elseif ($r['status'] == 'In Progress') {
                        echo '<span class="progress">In Progress</span>';
                    } elseif ($r['status'] == 'Completed') {
                        echo '<span class="completed">Completed</span>';
                    } elseif ($r['status'] == 'Rejected') {
                        echo '<span class="rejected">Rejected</span>';
                    } else {
                        echo $r['status'];
                    }
                    ?>

                </td>

                <td><?php echo $r['created_at']; ?></td>

            </tr>

        <?php endwhile; ?>

    </table>

</div>

</body>
</html>