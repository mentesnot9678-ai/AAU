<?php
session_start();
include("../config/db.php");

$error = "";

// If already logged in
if (isset($_SESSION['role']) && $_SESSION['role'] == "staff") {
    header("Location: ../staff/staff.php");
    exit();
}

if (isset($_POST['login'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check user
    $query = mysqli_query($conn, "
        SELECT * FROM users 
        WHERE username='$username' 
        AND role='staff'
        LIMIT 1
    ");

    if (mysqli_num_rows($query) == 1) {

        $user = mysqli_fetch_assoc($query);

        // If you are NOT using hashed passwords
        if ($password == $user['password']) {

            $_SESSION['user'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_id'] = $user['id'];

            header("Location: ../staff/staff.php");
            exit();

        } else {
            $error = "Incorrect password!";
        }

    } else {
        $error = "Staff account not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Staff Login</title>

    <link rel="stylesheet" href="../assets/css/dashboard.css">

    <style>

        body{
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
            background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
            font-family:Arial;
            color:white;
        }

        .login-box{
            width:350px;
            padding:30px;
            background:rgba(255,255,255,0.05);
            border:1px solid rgba(255,255,255,0.1);
            border-radius:15px;
            backdrop-filter:blur(10px);
        }

        h2{
            text-align:center;
            margin-bottom:20px;
            color:#00f7ff;
        }

        input{
            width:100%;
            padding:12px;
            margin:10px 0;
            border:none;
            border-radius:8px;
        }

        button{
            width:100%;
            padding:12px;
            background:#00f7ff;
            border:none;
            border-radius:8px;
            cursor:pointer;
            font-weight:bold;
        }

        button:hover{
            background:#00c2cc;
        }

        .error{
            color:red;
            text-align:center;
            margin-bottom:10px;
        }

    </style>

</head>

<body>

<div class="login-box">

    <h2>Staff Login</h2>

    <?php if ($error != ""): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">

        <input type="text" name="username" placeholder="Username" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" name="login">
            Login
        </button>

    </form>

</div>

</body>
</html>