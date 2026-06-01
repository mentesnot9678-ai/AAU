<?php
session_start();
include("../../config/db.php");

/* DRIVER ONLY */
if (
    !isset($_SESSION['role']) ||
    strtolower($_SESSION['role']) != "driver"
) {
    header("Location: ../../auth/login.php");
    exit();
}

$username = $_SESSION['user'];
$driver_id = $_SESSION['user_id'];

$success = "";
$error = "";

/* GET DRIVER ID */
$userQuery = mysqli_query(
    $conn,
    "SELECT id, username
     FROM users
     WHERE username='" . mysqli_real_escape_string($conn,$username) . "'
     LIMIT 1"
);

$user = mysqli_fetch_assoc($userQuery);

if (!$user) {
    die("Driver account not found. Logged in username: " . htmlspecialchars($username));
}

$driver_id = $user['id'];

/* SUBMIT REQUEST */
if (isset($_POST['submit'])) {

    $issue = mysqli_real_escape_string(
        $conn,
        trim($_POST['issue'])
    );

    if (!empty($issue)) {

        $insert = mysqli_query(
            $conn,
            "INSERT INTO service_requests
            (driver_id, issue, status)
            VALUES
            ('$driver_id','$issue','Pending Admin Approval')"
        );

        if ($insert) {
            $success = "Request submitted successfully!";
        } else {
            $error = mysqli_error($conn);
        }
    }
}

/* GET PREVIOUS REQUESTS */
$requests = mysqli_query(
    $conn,
    "SELECT *
     FROM service_requests
     WHERE driver_id='$driver_id'
     ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Submit Service Request</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
</head>

<body>
    <div class="sidebar">
        <h2>AAU VMS</h2>
        <a href="index.php">Dashboard</a>
       
        <a href="driverReport.php">Trip Reports</a>
        <a href="submit_service_request.php" class="active">Submit Service Request</a>
     
        
    </div>

    <div class="main">
        <h1>Submit Service Request</h1>

        <?php if ($success != ""): ?>
            <p style="color:green;"><?php echo $success; ?></p>
        <?php endif; ?>

        <form method="post">
            <label>Issue/Request:</label><br>
            <textarea name="issue" required></textarea><br><br>
            <button type="submit" name="submit">Submit Request</button>
        </form>

        <h2>Your Previous Requests</h2>
        <table border="1" cellpadding="10" style="color:white; margin-top:20px;">
            <tr>
                <th>ID</th>
                <th>Issue</th>
                <th>Status</th>
                <th>Submitted At</th>
            </tr>
            <?php while ($r = mysqli_fetch_assoc($requests)): ?>
                <tr>
                    <td><?php echo $r['id']; ?></td>
                    <td><?php echo $r['issue']; ?></td>
                    <td><?php echo $r['status']; ?></td>
                    <td><?php echo $r['created_at']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>

</html>