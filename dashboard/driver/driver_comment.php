<?php
session_start();
require_once __DIR__ . '/../../config/db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != "driver"){
    header("Location: ../auth/login.php");
    exit();
}

$driver_name = $_SESSION['user'] ?? "Driver";

/* SEND MESSAGE */
if(isset($_POST['send_comment'])){

    $message = mysqli_real_escape_string($conn, $_POST['message']);

    mysqli_query($conn, "
        INSERT INTO driver_comments (driver_name, message, status)
        VALUES ('$driver_name', '$message', 'Unread')
    ");
}

/* GET ALL COMMENTS OF THIS DRIVER */
$comments = mysqli_query($conn, "
    SELECT * FROM driver_comments 
    WHERE driver_name='$driver_name'
    ORDER BY created_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Driver Messages</title>

<style>
body{
    font-family:Segoe UI;
    background:#0f172a;
    color:white;
}

.main{
    margin-left:240px;
    padding:20px;
}

.box{
    background:rgba(255,255,255,0.06);
    padding:15px;
    margin-bottom:15px;
    border-radius:10px;
}

.reply{
    margin-top:10px;
    padding:10px;
    background:rgba(0,255,255,0.1);
    border-left:3px solid #00f7ff;
}

textarea{
    width:100%;
    height:100px;
    margin-top:10px;
}

button{
    margin-top:10px;
    padding:10px;
    background:#00f7ff;
    border:none;
    font-weight:bold;
    cursor:pointer;
}
.badge{
    padding:4px 8px;
    border-radius:10px;
    font-size:12px;
}
.Unread{background:red;}
.Read{background:orange;}
.Replied{background:green;}
</style>
</head>

<body>

<div class="main">

<h2>Send Message to Manager</h2>

<form method="POST">
    <textarea name="message" placeholder="Write your message..." required></textarea>
    <br>
    <button name="send_comment">Send</button>
</form>

<hr>

<h2>My Messages</h2>

<?php while($c = mysqli_fetch_assoc($comments)){ ?>

<div class="box">

    <b>Message:</b> <?php echo $c['message']; ?> <br>
    <small><?php echo $c['created_at']; ?></small><br>

    <span class="badge <?php echo $c['status']; ?>">
        <?php echo $c['status']; ?>
    </span>

    <!-- MANAGER REPLY -->
    <?php if(!empty($c['reply'])){ ?>
        <div class="reply">
            <b>Manager Reply:</b><br>
            <?php echo $c['reply']; ?><br>
            <small>
                By <?php echo $c['replied_by']; ?> |
                <?php echo $c['replied_at']; ?>
            </small>
        </div>
    <?php } ?>

</div>

<?php } ?>

</div>

</body>
</html>