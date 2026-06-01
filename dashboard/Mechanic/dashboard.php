<?php
session_start();
include("../../config/db.php");

/* AUTH */
if (!isset($_SESSION['role']) || $_SESSION['role'] != "mechanic") {
    header("Location: ../../auth/login.php");
    exit();
}

/* =========================
   ACTION HANDLER
========================= */
if (isset($_GET['action'], $_GET['id'])) {

    $id = (int) $_GET['id'];
    $action = $_GET['action'];

    $map = [
        "accept" => "Accepted",
        "reject" => "Rejected",
        "start"  => "In Repair",
        "fixed"  => "Fixed",
        "unrepairable" => "Unrepairable"
    ];

    if (isset($map[$action])) {
        $status = $map[$action];

        mysqli_query($conn, "
            UPDATE service_requests
            SET status='$status'
            WHERE id=$id
        ");
    }

    header("Location: dashboard.php");
    exit();
}

/* =========================
   FETCH DATA (ALL REQUESTS)
========================= */
$result = mysqli_query($conn, "
    SELECT sr.*, u.username
    FROM service_requests sr
    LEFT JOIN users u ON sr.driver_id = u.id
    ORDER BY sr.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Mechanic Dashboard</title>

<style>
body{
    margin:0;
    font-family:Segoe UI;
    background:#0f2027;
    color:white;
}

/* SIDEBAR (ADMIN STYLE INCLUDED) */
.sidebar{
    width:220px;
    height:100vh;
    position:fixed;
    left:0;
    top:0;
    background:#111827;
    padding:20px;
}

.sidebar h2{color:#00f7ff;}
.sidebar a{
    display:block;
    padding:10px;
    color:white;
    text-decoration:none;
}
.sidebar a:hover{
    background:#00f7ff;
    color:black;
}

/* MAIN */
.main{
    margin-left:240px;
    padding:20px;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    background:rgba(255,255,255,0.05);
}

th, td{
    padding:12px;
    border-bottom:1px solid rgba(255,255,255,0.1);
}

th{
    background:#111827;
    color:#00f7ff;
}

/* BUTTONS */
.btn{
    padding:6px 10px;
    border-radius:6px;
    text-decoration:none;
    font-size:12px;
    margin-right:5px;
    display:inline-block;
}

.accept{background:#3498db;color:white;}
.reject{background:#e74c3c;color:white;}
.start{background:#f39c12;color:black;}
.fixed{background:#2ecc71;color:white;}
.unrepairable{background:#7f1d1d;color:white;}

/* STATUS */
.s-pending{color:orange;font-weight:bold;}
.s-accepted{color:#3498db;font-weight:bold;}
.s-repair{color:#f39c12;font-weight:bold;}
.s-fixed{color:#2ecc71;font-weight:bold;}
.s-rejected{color:#e74c3c;font-weight:bold;}
.s-unrepairable{color:#7f1d1d;font-weight:bold;}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Mechanic Panel</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="#">Service Requests</a>
    <a href="../../auth/logout.php">Logout</a>
</div>

<div class="main">

<h2>Service Requests</h2>

<table>

<tr>
    <th>ID</th>
    <th>Driver</th>
    <th>Issue</th>
    <th>Status</th>
    <th>Actions</th>
</tr>

<?php while($r = mysqli_fetch_assoc($result)) { ?>

<tr>
    <td><?= $r['id']; ?></td>
    <td><?= htmlspecialchars($r['username'] ?? 'Driver'); ?></td>
    <td><?= htmlspecialchars($r['issue']); ?></td>

    <td>
        <?php
        switch($r['status']) {
            case "Accepted":
                echo "<span class='s-accepted'>Accepted</span>";
                break;
            case "In Repair":
                echo "<span class='s-repair'>In Repair</span>";
                break;
            case "Fixed":
                echo "<span class='s-fixed'>Fixed</span>";
                break;
            case "Rejected":
                echo "<span class='s-rejected'>Rejected</span>";
                break;
            case "Unrepairable":
                echo "<span class='s-unrepairable'>Unrepairable</span>";
                break;
            default:
                echo "<span class='s-pending'>Pending</span>";
        }
        ?>
    </td>

    <td>

        <!-- ALWAYS SHOW BUTTONS (FIXED) -->

        <a href="?action=accept&id=<?= $r['id']; ?>" class="btn accept">Accept</a>
        <a href="?action=start&id=<?= $r['id']; ?>" class="btn start">Start</a>
        <a href="?action=fixed&id=<?= $r['id']; ?>" class="btn fixed">Fix</a>
        <a href="?action=unrepairable&id=<?= $r['id']; ?>" class="btn unrepairable">Mark Unrepairable</a>

    </td>
</tr>

<?php } ?>

</table>

</div>

</body>
</html>