<?php
session_start();
include("../../config/db.php");

// Only manager can access
if(!isset($_SESSION['role']) || $_SESSION['role'] != "manager"){
    header("Location: ../../auth/login.php");
    exit();
}

// Fetch all users
$result = mysqli_query($conn,"SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Users - Manager</title>

<link rel="stylesheet" href="../../assets/css/dashboard.css">

<style>
body {
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background: linear-gradient(120deg,#0f2027,#203a43,#2c5364);
    color:white;
}

/* SIDEBAR */
.sidebar {
    position: fixed;
    left:0;
    top:0;
    width:250px;
    height:100%;
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(10px);
    padding:20px;
    transition: all 0.3s;
    overflow-y:auto;
    z-index:1000;
}

.sidebar h2 {
    color:#00f7ff;
    text-align:center;
    margin-bottom:20px;
}

.sidebar a {
    display:block;
    padding:10px;
    margin:10px 0;
    color:white;
    text-decoration:none;
    border-radius:6px;
    transition:.3s;
}

.sidebar a:hover,
.sidebar a.active {
    background:#00f7ff;
    color:black;
}

.main {
    margin-left:250px;
    padding:20px;
    transition: margin-left 0.3s;
}

.topbar {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.topbar h1 {
    margin:0;
    color:#00f7ff;
    text-shadow:0 0 10px #00f7ff;
}

.btn-toggle-sidebar {
    background:#00f7ff;
    color:black;
    border:none;
    padding:8px 15px;
    border-radius:6px;
    cursor:pointer;
    font-weight:bold;
}

/* ADD BUTTON */
.add-btn {
    display:inline-block;
    margin-bottom:20px;
    padding:10px 20px;
    background:#00f7ff;
    color:black;
    font-weight:bold;
    border-radius:8px;
    text-decoration:none;
    transition:.3s;
}

.add-btn:hover {
    box-shadow:0 0 20px #00f7ff;
    transform:translateY(-2px);
}

/* TABLE */
table {
    width:100%;
    border-collapse: collapse;
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(10px);
    border-radius: 10px;
    overflow:hidden;
}

table th, table td {
    padding:12px 10px;
    border-bottom:1px solid rgba(255,255,255,0.1);
    text-align:left;
}

table th {
    background: rgba(17,24,39,0.9);
    color:#00f7ff;
}

table tr:hover {
    background: rgba(0,247,255,0.1);
}

/* ACTION BUTTONS */
.action-btn {
    padding:6px 12px;
    border-radius:6px;
    text-decoration:none;
    font-size:14px;
    margin-right:5px;
    transition:.3s;
    display:inline-block;
}

.edit-btn {
    background:#facc15;
    color:#000;
}

.role-btn {
    background:#38bdf8;
    color:#000;
}

.delete-btn {
    background:#ef4444;
    color:#fff;
}

.edit-btn:hover { box-shadow:0 0 15px #facc15; }
.role-btn:hover { box-shadow:0 0 15px #38bdf8; }
.delete-btn:hover { box-shadow:0 0 15px #ef4444; }

@media screen and (max-width: 768px){
    .sidebar { width:200px; }
    .main { margin-left:200px; }
}

@media screen and (max-width: 576px){
    .sidebar { position:absolute; left:-250px; }
    .sidebar.active { left:0; }
    .main { margin-left:0; }
    .main.shifted { margin-left:250px; }
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <h2>AAU VMS</h2>

    <a href="manager_dashboard.php">Dashboard</a>
    <a href="manage_users.php" class="active">Users</a>
    <a href="assign_driver.php">Assign Driver</a>
    <a href="assign_vehicle.php">Assign Vehicle</a>
    <a href="manage_requests.php">Trip Requests</a>
    <a href="manager_vehicles.php">Vehicles</a>
    <a href="fleet_map.php">Map</a>

    <hr style="border:0.5px solid #444; margin:15px 0;">

    <a href="../../auth/logout.php">Logout</a>
</div>

<!-- MAIN -->
<div class="main" id="main-content">

    <div class="topbar">
        <h1>User Management (Manager)</h1>
        <button class="btn-toggle-sidebar" onclick="toggleSidebar()">☰ Menu</button>
    </div>

    <a href="add_user.php" class="add-btn">Add User</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>

        <?php while($row=mysqli_fetch_assoc($result)){ ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['role']; ?></td>
            <td>

                <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="action-btn edit-btn">Edit</a>

                <a href="delete_user.php?id=<?php echo $row['id']; ?>" 
                   class="action-btn delete-btn"
                   onclick="return confirm('Are you sure you want to delete this user?');">
                   Delete
                </a>

            </td>
        </tr>
        <?php } ?>

    </table>

</div>

<script>
function toggleSidebar(){
    const sidebar = document.getElementById('sidebar');
    const main = document.getElementById('main-content');
    sidebar.classList.toggle('active');
    main.classList.toggle('shifted');
}
</script>

</body>
</html>