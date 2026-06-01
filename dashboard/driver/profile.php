<?php
session_start();
include("../../config/db.php");

if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) != "driver") {
    header("Location: ../../auth/login.php");
    exit();
}

$username = $_SESSION['username'] ?? '';

/* USER DATA */
$user = null;

if ($username != '') {
    $user_result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    $user = mysqli_fetch_assoc($user_result);
}

/* UPDATE PROFILE */
if (isset($_POST['update']) && $user) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    mysqli_query($conn, "UPDATE users SET name='$name', email='$email' WHERE username='$username'");

    $user_result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    $user = mysqli_fetch_assoc($user_result);
}

/* LIVE STATS */
$trips_total = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM trips WHERE driver='$username'"));
$trips_pending = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM trips WHERE driver='$username' AND status='Pending'"));
$trips_done = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM trips WHERE driver='$username' AND status='Completed'"));
?>

<!DOCTYPE html>
<html>

<head>
    <title>Driver Profile</title>

    <link rel="stylesheet" href="../../assets/css/dashboard.css">

    <style>
        body {
            background: #0f2027;
            color: white;
            font-family: Arial;
        }

        .main {
            margin-left: 220px;
            padding: 30px;
        }

        /* PROFILE HEADER */
        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
            background: rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }

        .avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: #00f7ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
            color: black;
            font-weight: bold;
        }

        .profile-info h2 {
            margin: 0;
            color: #00f7ff;
        }

        /* STATS */
        .cards {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .card {
            flex: 1;
            min-width: 180px;
            background: rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: 12px;
            text-align: center;
        }

        .card h3 {
            color: #00f7ff;
        }

        /* FORM */
        .form-box {
            margin-top: 25px;
            background: rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: 12px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: none;
        }

        button {
            background: #00f7ff;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background: #00d4dd;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h2>AAU VMS</h2>
        <a href="index.php">Dashboard</a>
        <a href="profile.php" class="active">Profile</a>
        <a href="driverReport.php">Trip Reports</a>
        <a href="submit_service_request.php">Service Request</a>
        <a href="../../auth/logout.php">Logout</a>
    </div>

    <div class="main">

        <!-- PROFILE HEADER -->
        <div class="profile-header">

            <div class="avatar">
                <?php echo strtoupper(substr($user['name'] ?? 'D', 0, 1)); ?>
                </div> <div class="profile-info">
                <h2>
                    <?php echo htmlspecialchars($user['name'] ?? 'Driver'); ?>
                </h2>
                <p><?php echo htmlspecialchars($user['email'] ?? 'No email'); ?></p>
                <small>Username: <?php echo htmlspecialchars($username); ?></small>
            </div>

        </div>

        <!-- STATS -->
        <div class="cards">

            <div class="card">
                <h3>Total Trips</h3>
                <p>
                    <?php echo $trips_total; ?>
                </p>
            </div>

            <div class="card">
                <h3>Pending</h3>
                <p>
                    <?php echo $trips_pending; ?>
                </p>
            </div>

            <div class="card">
                <h3>Completed</h3>
                <p>
                    <?php echo $trips_done; ?>
                </p>
            </div>

        </div>

        <!-- UPDATE FORM -->
        <div class="form-box">

            <h3 style="color:#00f7ff;">Update Profile</h3>

            <form method="post">

                <label>Name</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>">

                <label>Email</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">

                <button type="submit" name="update">Update</button>

            </form>

        </div>

    </div>

</body>

</html>