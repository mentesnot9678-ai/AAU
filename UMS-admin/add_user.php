<?php
include("../config/db.php");

if(isset($_POST['add'])){

$name=$_POST['name'];
$email=$_POST['email'];
$password=$_POST['password'];
$role=$_POST['role'];

mysqli_query($conn,"INSERT INTO users(name,email,password,role)
VALUES('$name','$email','$password','$role')");

header("Location: users.php");
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Add User</title>

<style>

body{
background:#0f172a;
color:white;
font-family:Segoe UI;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
}

.card{
background:#1e293b;
padding:40px;
border-radius:12px;
width:350px;
}

input,select{
width:100%;
padding:10px;
margin-bottom:15px;
border:none;
border-radius:6px;
}

button{
width:100%;
padding:12px;
background:#38bdf8;
border:none;
border-radius:8px;
font-weight:bold;
cursor:pointer;
}

</style>

</head>

<body>

<div class="card">

<h2>Add User</h2>

<form method="POST">

<input type="text" name="name" placeholder="Name" required>

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Password" required>

<select name="role">

<option>manager</option>
<option>driver</option>
<option>staff</option>
<option>mechanic</option>

</select>

<button name="add">Add User</button>

</form>

</div>

</body>
</html>