<?php
include("../config/db.php");

$result = mysqli_query($conn,"SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
<title>User Management</title>
<style>

body{
background:#0f172a;
color:white;
font-family:Segoe UI;
padding:40px;
}

table{
width:100%;
border-collapse:collapse;
margin-top:20px;
}

th,td{
padding:12px;
border-bottom:1px solid #334155;
}

th{
color:#38bdf8;
}

.btn{
padding:8px 12px;
border-radius:6px;
background:#ef4444;
color:white;
text-decoration:none;
}

.addbtn{
background:#38bdf8;
padding:10px 15px;
border-radius:8px;
color:black;
text-decoration:none;
}

</style>
</head>

<body>

<h2>👥 User Management</h2>

<a class="addbtn" href="add_user.php">➕ Add User</a>

<table>

<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Role</th>
<th>Action</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>
<td><?= $row['id'] ?></td>
<td><?= $row['name'] ?></td>
<td><?= $row['email'] ?></td>
<td><?= $row['role'] ?></td>

<td>
<a class="btn" href="delete_user.php?id=<?= $row['id'] ?>">Delete</a>
</td>

</tr>

<?php } ?>

</table>

</body>
</html>