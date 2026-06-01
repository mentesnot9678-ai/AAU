<?php
session_start();
include("../../config/db.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] != "manager") {
    header("Location: ../../auth/login.php");
    exit();
}

$requests = mysqli_query($conn, "SELECT * FROM exit_requests ORDER BY id DESC");
?>

<h2>Gate Exit Requests</h2>

<table border="1" cellpadding="10" cellspacing="0">

<tr>
    <th>ID</th>
    <th>Driver</th>
    <th>Vehicle</th>
    <th>Reason</th>
    <th>Date</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php while($r = mysqli_fetch_assoc($requests)) { ?>

<tr>

    <td><?php echo $r['id']; ?></td>
    <td><?php echo $r['driver']; ?></td>
    <td><?php echo $r['vehicle_id']; ?></td>
    <td><?php echo $r['reason']; ?></td>
    <td><?php echo $r['request_date']; ?></td>

    <td>
        <?php
            if($r['status'] == "Pending") {
                echo "<span style='color:orange;'>Pending</span>";
            } elseif($r['status'] == "Approved") {
                echo "<span style='color:lime;'>Approved</span>";
            } elseif($r['status'] == "Rejected") {
                echo "<span style='color:red;'>Rejected</span>";
            } elseif($r['status'] == "Exited") {
                echo "<span style='color:cyan;'>Exited</span>";
            }
        ?>
    </td>

    <td>

        <!-- BUTTON 1: APPROVE -->
        <?php if($r['status'] == "Pending") { ?>

            <a href="update_exit.php?id=<?php echo $r['id']; ?>&status=Approved"
               style="padding:5px 10px;background:green;color:white;text-decoration:none;border-radius:5px;">
                Approve
            </a>

            <!-- BUTTON 2: REJECT -->
            <a href="update_exit.php?id=<?php echo $r['id']; ?>&status=Rejected"
               style="padding:5px 10px;background:red;color:white;text-decoration:none;border-radius:5px;">
                Reject
            </a>

        <?php } ?>

        <!-- BUTTON 3: MARK EXITED -->
        <?php if($r['status'] == "Approved") { ?>

            <a href="update_exit.php?id=<?php echo $r['id']; ?>&status=Exited"
               style="padding:5px 10px;background:blue;color:white;text-decoration:none;border-radius:5px;">
                Mark Exited
            </a>

        <?php } ?>

        <?php if($r['status'] == "Rejected" || $r['status'] == "Exited") { ?>
            <span>-</span>
        <?php } ?>

    </td>

</tr>

<?php } ?>

</table>