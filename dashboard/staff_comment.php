<?php
session_start();
require_once __DIR__ . '/../config/db.php';

/* SHOW ERRORS (DEBUG MODE) */
error_reporting(E_ALL);
ini_set('display_errors', 1);

/* AUTH CHECK */
if(!isset($_SESSION['role']) || $_SESSION['role'] != "staff"){
    header("Location: ../auth/login.php");
    exit();
}

$staff_name = $_SESSION['user'] ?? "Staff";

$success = "";
$error = "";

/* =========================
   SEND MESSAGE
========================= */
if(isset($_POST['send_comment'])){

    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $insert = mysqli_query($conn,"
        INSERT INTO staff_comments (staff_name, message, status)
        VALUES ('$staff_name', '$message', 'Unread')
    ");

    if($insert){
        $success = "Message sent successfully!";
    } else {
        $error = "DB Error: " . mysqli_error($conn);
    }
}

/* =========================
   FETCH MESSAGES
========================= */
$comments = mysqli_query($conn,"
    SELECT * FROM staff_comments
    WHERE staff_name='$staff_name'
    ORDER BY created_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Staff Comments</title>

<style>
body{
    font-family:Segoe UI;
    background:#f4f6f9;
}

.main{
    margin-left:250px;
    padding:20px;
}

.box{
    background:white;
    padding:15px;
    margin-bottom:15px;
    border-radius:10px;
    border:1px solid #ddd;
}

textarea{
    width:100%;
    padding:10px;
    margin-top:10px;
    height:120px;
}

button{
    margin-top:10px;
    padding:10px 15px;
    background:#00f7ff;
    border:none;
    font-weight:bold;
    cursor:pointer;
}

.success{color:green;font-weight:bold;}
.error{color:red;font-weight:bold;}

.badge{
    padding:4px 10px;
    border-radius:6px;
    font-size:12px;
}

.Unread{background:red;color:white;}
.Replied{background:green;color:white;}

.reply{
    margin-top:10px;
    padding:10px;
    background:#e6fffa;
    border-left:3px solid #00f7ff;
}
</style>
</head>

<body>

<div class="main">

<h2>Staff Messages</h2>

<!-- SUCCESS / ERROR -->
<?php if($success) echo "<p class='success'>$success</p>"; ?>
<?php if($error) echo "<p class='error'>$error</p>"; ?>

<!-- SEND FORM -->
<form method="POST">
    <textarea name="message" required placeholder="Type message to manager..."></textarea>
    <button type="submit" name="send_comment">Send Message</button>
</form>

<hr>

<!-- MESSAGES -->
<?php if($comments && mysqli_num_rows($comments) > 0){ ?>

    <?php while($c = mysqli_fetch_assoc($comments)){ ?>

    <div class="box">

        <b>Message:</b><br>
        <?php echo htmlspecialchars($c['message']); ?><br>

        <small><?php echo $c['created_at']; ?></small><br>

        <span class="badge <?php echo $c['status']; ?>">
            <?php echo $c['status']; ?>
        </span>

        <!-- MANAGER REPLY -->
        <?php if(!empty($c['reply'])){ ?>
            <div class="reply">
                <b>Manager Reply:</b><br>
                <?php echo htmlspecialchars($c['reply']); ?><br>

                <small>
                    By <?php echo $c['replied_by']; ?> |
                    <?php echo $c['replied_at']; ?>
                </small>
            </div>
        <?php } ?>

    </div>

    <?php } ?>

<?php } else { ?>

    <p>No messages yet.</p>

<?php } ?>

</div>

</body>
</html>