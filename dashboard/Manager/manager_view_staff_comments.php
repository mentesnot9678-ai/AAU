<?php
session_start();
require_once __DIR__ . '/../../config/db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != "manager"){
    header("Location: ../auth/login.php");
    exit();
}

/* REPLY MESSAGE */
if(isset($_POST['reply_submit'])){

    $id = (int) $_POST['comment_id'];
    $reply = mysqli_real_escape_string($conn, $_POST['reply']);
    $manager = $_SESSION['user'];

    mysqli_query($conn, "
        UPDATE staff_comments
        SET reply='$reply',
            replied_by='$manager',
            replied_at=NOW(),
            status='Read'
        WHERE id=$id
    ");
}

/* FETCH ALL MESSAGES */
$comments = mysqli_query($conn, "
    SELECT * FROM staff_comments
    ORDER BY created_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Staff Messages</title>

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

.Unread{background:red;color:white;}
.Read{background:orange;color:black;}

.reply{
    background:#e6fffa;
    padding:10px;
    margin-top:10px;
    border-left:3px solid #00f7ff;
}
</style>
</head>

<body>

<div class="main">

<h2>Staff Messages</h2>

<?php while($c = mysqli_fetch_assoc($comments)){ ?>

<div class="box">

    <b>Staff:</b> <?php echo htmlspecialchars($c['staff_name']); ?><br>
    <b>Message:</b> <?php echo htmlspecialchars($c['message']); ?><br>
    <small><?php echo $c['created_at']; ?></small><br>

    <span class="<?php echo $c['status']; ?>">
        <?php echo $c['status']; ?>
    </span>

    <?php if(!empty($c['reply'])){ ?>
        <div class="reply">
            <b>Reply:</b><br>
            <?php echo htmlspecialchars($c['reply']); ?><br>
            <small>
                By <?php echo $c['replied_by']; ?> |
                <?php echo $c['replied_at']; ?>
            </small>
        </div>
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