<?php
session_start();
include("../../config/db.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] != "manager") {
    header("Location: ../../auth/login.php");
    exit();
}

/* =========================
   HANDLE ACTIONS (SEND / REJECT)
========================= */
if (isset($_GET['action']) && isset($_GET['id'])) {

    $id = (int)$_GET['id'];
    $action = $_GET['action'];

    if ($action === "send") {
        mysqli_query($conn, "
            UPDATE service_requests 
            SET status='Sent to Mechanic'
            WHERE id=$id
        ");
    }

    if ($action === "reject") {
        mysqli_query($conn, "
            UPDATE service_requests 
            SET status='Rejected'
            WHERE id=$id
        ");
    }

    header("Location: manage_requests.php");
    exit();
}

/* =========================
   FETCH REQUESTS
========================= */
$requests = mysqli_query($conn, "
SELECT sr.*, u.username
FROM service_requests sr
LEFT JOIN users u ON sr.driver_id = u.id
ORDER BY sr.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Service Requests</title>

<style>
body{
    margin:0;
    font-family:Segoe UI;
    background:#0f2027;
    color:white;
}

.sidebar{
    width:220px;
    height:100vh;
    position:fixed;
    left:0;
    top:0;
    background:#111827;
}

.sidebar h2{
    text-align:center;
    color:#00f7ff;
    padding:20px 0;
}

.sidebar a{
    display:block;
    padding:12px 20px;
    color:white;
    text-decoration:none;
}

.sidebar a:hover,
.sidebar .active{
    background:#00f7ff;
    color:black;
}

.main{
    margin-left:240px;
    padding:30px;
}

table{
    width:100%;
    border-collapse:collapse;
    background:rgba(255,255,255,0.05);
}

th{
    background:#00f7ff;
    color:black;
    padding:12px;
}

td{
    padding:12px;
    border-bottom:1px solid rgba(255,255,255,0.1);
}

tr:hover{
    background:rgba(255,255,255,0.05);
}

.pending{color:orange;font-weight:bold;}
.progress{color:#00f7ff;font-weight:bold;}
.completed{color:lime;font-weight:bold;}
.rejected{color:red;font-weight:bold;}

.btn{
    display:inline-block;
    padding:7px 12px;
    border-radius:6px;
    text-decoration:none;
    font-size:13px;
    font-weight:bold;
    margin:2px;
}

.send{background:#00f7ff;color:black;}
.rejectbtn{background:red;color:white;}
.done{background:limegreen;color:white;}
</style>
</head>

<body>

<div class="sidebar">
    <h2>AAU VMS</h2>

    <a href="manager_dashboard.php">Dashboard</a>
    <a href="manage_requests.php">Trip Requests</a>
    <a href="manage_requests.php" class="active">Service Requests</a>
    <a href="manager_vehicles.php">Vehicles</a>
    <a href="../../auth/logout.php">Logout</a>
</div>

<div class="main">

<h1>Driver Service Requests</h1>

<table>

<tr>
    <th>ID</th>
    <th>Driver</th>
    <th>Issue</th>
    <th>Status</th>
    <th>Date</th>
    <th>Action</th>
</tr>

<?php if ($requests && mysqli_num_rows($requests) > 0) { ?>

    <?php while ($r = mysqli_fetch_assoc($requests)) { ?>

    <tr>
        <td><?= $r['id']; ?></td>
        <td><?= htmlspecialchars($r['username'] ?? 'Unknown'); ?></td>
        <td><?= htmlspecialchars($r['issue']); ?></td>

        <td>
            <?php
            if ($r['status'] == "Pending Admin Approval") {
                echo "<span class='pending'>Pending</span>";
            } elseif ($r['status'] == "Sent to Mechanic") {
                echo "<span class='progress'>Sent to Mechanic</span>";
            } elseif ($r['status'] == "In Progress") {
                echo "<span class='progress'>In Progress</span>";
            } elseif ($r['status'] == "Completed") {
                echo "<span class='completed'>Completed</span>";
            } elseif ($r['status'] == "Rejected") {
                echo "<span class='rejected'>Rejected</span>";
            } else {
                echo htmlspecialchars($r['status']);
            }
            ?>
        </td>

        <td><?= $r['created_at']; ?></td>

        <td>
            <?php if ($r['status'] == "Pending Admin Approval") { ?>

                <a href="?action=send&id=<?= $r['id']; ?>" class="btn send">
                    Send to Mechanic
                </a>

                <a href="?action=reject&id=<?= $r['id']; ?>" class="btn rejectbtn">
                    Reject
                </a>

            <?php } elseif ($r['status'] == "Completed") { ?>

                <span class="btn done">Fixed</span>

            <?php } else { ?>

                <span>-</span>

            <?php } ?>
        </td>

    </tr>

    <?php } ?>

<?php } else { ?>

<tr>
    <td colspan="6">No service requests found.</td>
</tr>

<?php } ?>

</table>

</div>

</body>
</html>