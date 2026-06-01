<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) != "admin") {
    header("Location: ../auth/login.php");
    exit();
}

if(isset($_POST['add'])){

    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = strtolower($_POST['role']);

    // check duplicate username
    $check = mysqli_query($conn,"SELECT id FROM users WHERE username='$username'");

    if(mysqli_num_rows($check) > 0){
        echo "<script>alert('Username already exists');</script>";
    } else {

        mysqli_query($conn,"
            INSERT INTO users(username,password,role,status)
            VALUES('$username','$password','$role','active')
        ");

        // 🔥 FIXED REDIRECT
        header("Location: admin.php");
        exit();
    }
}
?>

<h2>Add User</h2>

<form method="POST">

<input type="text" name="username" placeholder="Username" required>

<input type="password" name="password" placeholder="Password" required>

<select name="role">
<option value="admin">Admin</option>
<option value="staff">Staff</option>
<option value="driver">Driver</option>
<option value="mechanic">Mechanic</option>
<option value="manager">Manager</option>
</select>

<button name="add">Add User</button>

</form>