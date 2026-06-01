<?php
session_start();
require_once __DIR__ . '/../../config/db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != "manager"){
    header("Location: ../auth/login.php");
    exit();
}

/* MARK AS READ */
if(isset($_GET['read'])){
    $id = (int) $_GET['read'];
    mysqli_query($conn, "UPDATE driver_comments SET status='Read' WHERE id=$id");
}

/* REPLY TO COMMENT */
if(isset($_POST['reply_submit'])){

    $comment_id = (int) $_POST['comment_id'];
    $reply = mysqli_real_escape_string($conn, $_POST['reply']);
    $manager = $_SESSION['user'];

    mysqli_query($conn, "
        UPDATE driver_comments 
        SET reply='$reply',
            replied_by='$manager',
            replied_at=NOW(),
            status='Replied'
        WHERE id=$comment_id
    ");
}

$comments = mysqli_query($conn, "SELECT * FROM driver_comments ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Driver Messages</title>

<style>
body{
    font-family:Segoe UI;
    background:#f4f6f9;
}

.main{
    margin-left:250px;
    padding:20px;
}

.comment-box{
    background:white;
    padding:15px;
    margin-bottom:15px;
    border-radius:10px;
    border:1px solid #ddd;
}

.badge{
    padding:4px 10px;
    border-radius:10px;
    font-size:12px;
}

.Unread{background:red;color:white;}
.Read{background:orange;color:black;}
.Replied{background:green;color:white;}

textarea{
    width:100%;
    margin-top:10px;
    padding:8px;
}

button{
    margin-top:5px;
    padding:8px 12px;
    background:#00f7ff;
    border:none;
    cursor:pointer;
    font-weight:bold;
}
</style>

</head>

<body>

<div class="main">

<h2>Driver Messages</h2>

<?php while($c = mysqli_fetch_assoc($comments)){ ?>

<div class="comment-box">

    <b>Driver:</b> <?php echo $c['driver_name']; ?> <br>
    <b>Message:</b> <?php echo $c['message']; ?> <br>
    <b>Date:</b> <?php echo $c['created_at']; ?> <br>

    <span class="badge <?php echo $c['status']; ?>">
        <?php echo $c['status']; ?>
    </span>

    <?php if(!empty($c['reply'])){ ?>
        <hr>
        <b>Reply:</b> <?php echo $c['reply']; ?><br>
        <small>By: <?php echo $c['replied_by']; ?> | <?php echo $c['replied_at']; ?></small>
    <?php } ?>

    <!-- MARK READ -->
    <?php if($c['status'] == "Unread"){ ?>
        <br><a href="?read=<?php echo $c['id']; ?>">Mark as Read</a>
    <?php } ?>

    <!-- REPLY FORM -->
    <form method="POST">
        <input type="hidden" name="comment_id" value="<?php echo $c['id']; ?>">
        <textarea name="reply" placeholder="Write reply..." required></textarea>
        <button name="reply_submit">Send Reply</button>
    </form>

</div>

<?php } ?>

</div>

</body>
</html>