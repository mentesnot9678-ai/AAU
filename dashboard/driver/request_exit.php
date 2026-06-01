<?php
session_start();
include("../../config/db.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] != "driver") {
    header("Location: ../../auth/login.php");
    exit();
}

$driver = $_SESSION['user'];

/* Submit request */
if (isset($_POST['request_exit'])) {

    $vehicle_id = mysqli_real_escape_string($conn, $_POST['vehicle_id']);
    $reason = mysqli_real_escape_string($conn, $_POST['reason']);

    mysqli_query($conn, "
        INSERT INTO exit_requests (driver, vehicle_id, reason)
        VALUES ('$driver', '$vehicle_id', '$reason')
    ");

    echo "<script>alert('Exit request sent!');</script>";
}

/* Vehicles */
$vehicles = mysqli_query($conn, "SELECT * FROM vehicles");
?>

<h2>Request Gate Exit</h2>

<form method="POST">

    <select name="vehicle_id" required>
        <option value="">Select Vehicle</option>
        <?php while($v = mysqli_fetch_assoc($vehicles)) { ?>
            <option value="<?php echo $v['id']; ?>">
                <?php echo $v['vehicle_name']; ?>
            </option>
        <?php } ?>
    </select>

    <textarea name="reason" placeholder="Reason for exit" required></textarea>

    <button name="request_exit">Request Exit</button>

</form>