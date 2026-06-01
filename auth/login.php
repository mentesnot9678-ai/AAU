<?php
session_start();
include("../config/db.php");
/*error*/ 
$error = "";

/* AUTO REDIRECT IF LOGGED IN */
if (isset($_SESSION['role'])) {

    switch (strtolower($_SESSION['role'])) {

        case "admin":
            header("Location: ../dashboard/admin.php");
            exit();

        case "manager":
            header("Location: ../dashboard/manager/manager_dashboard.php");
            exit();

        case "driver":
            header("Location: ../dashboard/driver/index.php");
            exit();

        case "mechanic":
            header("Location: ../dashboard/mechanic/dashboard.php");
            exit();

        case "staff":
            header("Location: ../dashboard/staff.php");
            exit();
    }
}

/* LOGIN PROCESS */
if (isset($_POST['login'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($conn,
        "SELECT * FROM users WHERE username='$username' LIMIT 1"
    );

    $user = mysqli_fetch_assoc($query);

    // 1. USER EXISTS?
    if (!$user) {
        $error = "User not found!";
    }

    // 2. PASSWORD CHECK
    elseif (
        !password_verify($password, $user['password']) &&
        $password != $user['password']
    ) {
        $error = "Invalid username or password!";
    }

    // 3. STATUS CHECK (SAFE - NO WARNING)
    elseif (($user['status'] ?? 'inactive') != 'active') {
        $error = "Your account is deactivated. Contact admin.";
    }

    // 4. LOGIN SUCCESS
    else {

        $_SESSION['user'] = $user['username'];
        $_SESSION['role'] = strtolower($user['role']);
        $_SESSION['user_id'] = $user['id'];

        switch ($_SESSION['role']) {

            case "admin":
                header("Location: ../dashboard/admin.php");
                exit();

            case "manager":
                header("Location: ../dashboard/manager/manager_dashboard.php");
                exit();

            case "driver":
                header("Location: ../dashboard/driver/index.php");
                exit();

            case "mechanic":
                header("Location: ../dashboard/mechanic/dashboard.php");
                exit();

            case "staff":
                header("Location: ../dashboard/staff.php");
                exit();

            default:
                $error = "Invalid role assigned!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>AAU Login</title>

    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: linear-gradient(120deg, #0f2027, #203a43, #2c5364);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .login-box {
            width: 350px;
            padding: 30px;
            background: rgba(0, 0, 0, 0.6);
            border-radius: 12px;
            box-shadow: 0 0 20px #00f7ff;
            text-align: center;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 8px;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #00f7ff;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #00d4dd;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }

        h2 {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

<div class="login-box">

    <h2>AAU Login</h2>

    <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>

    <form method="POST">

        <input type="text" name="username" placeholder="Username" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" name="login">Login</button>

    </form>

</div>

</body>
</html>