<?php
session_start();
include("../config/db.php");

// Only staff
if (!isset($_SESSION['role']) || $_SESSION['role'] != "staff") {
    header("Location: ../auth/login.php");
    exit();
}

$username = $_SESSION['username'] ?? $_SESSION['user'] ?? '';

if ($username == '') {
    die("Session username not found.");
}

$success = "";

/* =========================
   SUBMIT TRIP
========================= */
if (isset($_POST['submit'])) {

    $vehicle_id = (int)$_POST['vehicle_id'];
    $destination = mysqli_real_escape_string($conn, trim($_POST['destination']));
    $trip_date = mysqli_real_escape_string($conn, $_POST['trip_date']);

    // Prevent duplicate pending requests
    $check = mysqli_query($conn, "
        SELECT id
        FROM trips
        WHERE driver='$username'
        AND vehicle_id='$vehicle_id'
        AND destination='$destination'
        AND trip_date='$trip_date'
        AND status='Pending Staff Approval'
    ");

    if (mysqli_num_rows($check) == 0) {

        mysqli_query($conn, "
            INSERT INTO trips
            (vehicle_id, driver, destination, trip_date, status)
            VALUES
            ('$vehicle_id', '$username', '$destination', '$trip_date', 'Pending Staff Approval')
        ");
    }

    $_SESSION['trip_success'] = "Trip request submitted successfully.";

    header("Location: staff_request_trip.php");
    exit();
}

/* =========================
   SUCCESS MESSAGE
========================= */
if (isset($_SESSION['trip_success'])) {
    $success = $_SESSION['trip_success'];
    unset($_SESSION['trip_success']);
}

/* =========================
   GET VEHICLES
========================= */
$vehicles = mysqli_query($conn, "
    SELECT id, vehicle_name, plate_number
    FROM vehicles
    ORDER BY vehicle_name
");

/* =========================
   STAFF TRIPS
========================= */
$trips = mysqli_query($conn, "
    SELECT
        t.id,
        t.vehicle_id,
        t.destination,
        t.trip_date,
        t.status,
        v.vehicle_name,
        v.plate_number
    FROM trips t
    LEFT JOIN vehicles v
        ON t.vehicle_id = v.id
    WHERE t.driver='$username'
    ORDER BY t.id DESC
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Staff Service Request</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">

    <style>
        table{
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
            color:white;
        }

        th,td{
            padding:10px;
            border:1px solid #444;
        }

        select,input{
            width:100%;
            padding:10px;
            margin-top:5px;
        }

        button{
            padding:10px 20px;
            cursor:pointer;
        }
    </style>
</head>

<body>

<div class="main">

    <h2>Request a Trip</h2>

    <?php if ($success): ?>
        <p style="color:lime;font-weight:bold;">
            <?php echo $success; ?>
        </p>
    <?php endif; ?>

    <form method="POST">

        <label>Vehicle</label>

        <select name="vehicle_id" required>

            <option value="">Select Vehicle</option>

            <?php while($v = mysqli_fetch_assoc($vehicles)): ?>

                <option value="<?php echo $v['id']; ?>">

                    <?php
                    echo htmlspecialchars(
                        $v['vehicle_name'] .
                        " (" .
                        $v['plate_number'] .
                        ")"
                    );
                    ?>

                </option>

            <?php endwhile; ?>

        </select>

        <br><br>

        <label>Destination</label>

        <input
            type="text"
            name="destination"
            required
        >

        <br><br>

        <label>Trip Date</label>

        <input
            type="date"
            name="trip_date"
            required
        >

        <br><br>

        <button type="submit" name="submit">
            Request Trip
        </button>

    </form>

    <h2 style="margin-top:40px;">
        My Trip Requests
    </h2>

    <table>

        <tr>
            <th>ID</th>
            <th>Vehicle</th>
            <th>Destination</th>
            <th>Trip Date</th>
            <th>Status</th>
        </tr>

        <?php while($t = mysqli_fetch_assoc($trips)): ?>

        <tr>

            <td><?php echo $t['id']; ?></td>

            <td>
                <?php
                echo $t['vehicle_name']
                ? htmlspecialchars($t['vehicle_name'])
                : 'Not Assigned';
                ?>
            </td>

            <td>
                <?php echo htmlspecialchars($t['destination']); ?>
            </td>

            <td>
                <?php echo $t['trip_date']; ?>
            </td>

            <td>
                <?php echo htmlspecialchars($t['status']); ?>
            </td>

        </tr>

        <?php endwhile; ?>

    </table>

</div>

</body>
</html>