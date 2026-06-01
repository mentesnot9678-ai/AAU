<?php
session_start();
include("../../config/db.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] != "driver") {
    header("Location: ../../auth/login.php");
    exit();
}

$driver = $_SESSION['user'];

$requests = mysqli_query($conn, "
    SELECT * FROM exit_requests
    WHERE driver='$driver'
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Exit Requests</title>

    <style>
        body{
            font-family:Segoe UI;
            background:#0f172a;
            color:white;
            padding:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            background:rgba(255,255,255,0.05);
        }

        th,td{
            padding:12px;
            border-bottom:1px solid rgba(255,255,255,0.1);
            text-align:center;
        }

        th{
            background:#111827;
            color:#00f7ff;
        }

        .pending{color:orange;}
        .approved{color:lime;}
        .rejected{color:red;}
        .exited{color:cyan;}
    </style>
</head>

<body>

<h2>🚪 My Exit Requests</h2>

<table>

<tr>
    <th>ID</th>
    <th>Vehicle</th>
    <th>Reason</th>
    <th>Date</th>
    <th>Status</th>
</tr>

<?php if(mysqli_num_rows($requests) > 0){ ?>

    <?php while($r = mysqli_fetch_assoc($requests)){ ?>

    <tr>
        <td><?php echo $r['id']; ?></td>
        <td><?php echo $r['vehicle_id']; ?></td>
        <td><?php echo $r['reason']; ?></td>
        <td><?php echo $r['request_date']; ?></td>

        <td>
            <?php
                if($r['status']=="Pending"){
                    echo "<span class='pending'>Pending</span>";
                }
                elseif($r['status']=="Approved"){
                    echo "<span class='approved'>Approved</span>";
                }
                elseif($r['status']=="Rejected"){
                    echo "<span class='rejected'>Rejected</span>";
                }
                elseif($r['status']=="Exited"){
                    echo "<span class='exited'>Exited</span>";
                }
            ?>
        </td>
    </tr>

    <?php } ?>

<?php } else { ?>

    <tr>
        <td colspan="5">No exit requests found</td>
    </tr>

<?php } ?>

</table>

</body>
</html>