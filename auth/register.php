<?php
include("../config/db.php");

if(isset($_POST['register'])){

$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

$sql = "INSERT INTO users(username,password,role)
VALUES('$username','$password','$role')";

mysqli_query($conn,$sql);

header("Location: login.php");

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>
</head>

<body>

<h2>Register User</h2>

<form method="POST">

<input type="text" name="username" placeholder="username" required>

<input type="password" name="password" placeholder="password" required>

<select name="role">
<option value="staff">Staff</option>
<option value="driver">Driver</option>
<option value="admin">Admin</option>
</select>

<button name="register">Register</button>

</form>

</body>
</html>