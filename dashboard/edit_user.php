<?php
session_start();
include("../config/db.php");

// Only admin can access
if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    header("Location: ../auth/login.php");
    exit();
}

// Get ID
if (!isset($_GET['id'])) {
    header("Location: admin.php");
    exit();
}

$id = (int)$_GET['id'];

// Fetch user
$result = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");

if (mysqli_num_rows($result) != 1) {
    header("Location: admin.php");
    exit();
}

$user = mysqli_fetch_assoc($result);

// UPDATE USER
if (isset($_POST['update_user'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $role     = mysqli_real_escape_string($conn, $_POST['role']);

    // update password only if filled
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "
            UPDATE users
            SET username='$username',
                email='$email',
                role='$role',
                password='$password'
            WHERE id=$id
        ";
    } else {
        $sql = "
            UPDATE users
            SET username='$username',
                email='$email',
                role='$role'
            WHERE id=$id
        ";
    }

    mysqli_query($conn, $sql);

    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit User</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:#0f172a;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    color:white;
}

.box{
    background:#111827;
    padding:30px;
    border-radius:12px;
    width:400px;
}

input,select,button{
    width:100%;
    padding:10px;
    margin-top:10px;
    border-radius:6px;
    border:none;
}

button{
    background:#00f7ff;
    font-weight:bold;
    cursor:pointer;
}

label{
    font-size:13px;
    color:#aaa;
}
</style>

</head>
<body>

<div class="box">

<h2>Edit User</h2>

<form method="POST">

<label>Username</label>
<input type="text"
       name="username"
       value="<?php echo htmlspecialchars($user['username']); ?>"
       required>

<label>Email (optional)</label>
<input type="email"
       name="email"
       value="<?php echo htmlspecialchars($user['email']); ?>">

<label>Role</label>
<select name="role">

    <option value="admin" <?php if($user['role']=='admin') echo 'selected'; ?>>Admin</option>
    <option value="manager" <?php if($user['role']=='manager') echo 'selected'; ?>>Manager</option>
    <option value="staff" <?php if($user['role']=='staff') echo 'selected'; ?>>Staff</option>
    <option value="driver" <?php if($user['role']=='driver') echo 'selected'; ?>>Driver</option>
    <option value="mechanic" <?php if($user['role']=='mechanic') echo 'selected'; ?>>Mechanic</option>

</select>

<label>New Password (leave empty to keep old)</label>
<input type="password" name="password" placeholder="Enter new password">

<button type="submit" name="update_user">
    Update User
</button>

</form>

</div>

</body>
</html>