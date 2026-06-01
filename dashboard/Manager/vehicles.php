<?php
session_start();

// FIXED PATH
require_once __DIR__ . '/../../config/db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != "manager"){
    header("Location: ../auth/login.php");
    exit();
}
// Fetch all vehicles
$result = mysqli_query($conn,"SELECT * FROM vehicles");
?>

<!DOCTYPE html>
<html>
<head>
<title>Vehicles - Manager</title>
<link rel="stylesheet" href="../assets/css/dashboard.css">
<style>
/* Layout and background */
body {
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background: linear-gradient(120deg,#0f2027,#203a43,#2c5364);
    color:white;
}

/* Sidebar */
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

/* Main content */
.main {
    margin-left:250px;
    padding:20px;
    transition: margin-left 0.3s;
}

/* Topbar */
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
.btn-toggle-sidebar:hover {
    box-shadow:0 0 20px #00f7ff;
    transform:translateY(-2px);
}

/* Add Vehicle button */
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

/* Table styles */
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

/* Action buttons */
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

.edit-btn:hover {
    box-shadow:0 0 15px #facc15;
}

.delete-btn {
    background:#ef4444;
    color:#fff;
}

.delete-btn:hover {
    box-shadow:0 0 15px #ef4444;
}

/* Responsive */
@media screen and (max-width: 768px){
    .sidebar {
        width:200px;
    }
    .main {
        margin-left:200px;
    }
    table th, table td {
        font-size:14px;
        padding:8px;
    }
}

@media screen and (max-width: 576px){
    .sidebar {
        position: absolute;
        left:-250px;
    }
    .sidebar.active {
        left:0;
    }
    .main {
        margin-left:0;
    }
    .main.shifted {
        margin-left:250px;
    }
    .topbar {
        flex-wrap:wrap;
        justify-content:space-between;
    }
}
</style>
</head>
<body>

<div class="sidebar" id="sidebar">
<h2>AAU VMS</h2>
<a href="manager_dashboard.php">Dashboard</a>
</div>

<div class="main" id="main-content">
<div class="topbar">
<h1>Vehicles</h1>
<button class="btn-toggle-sidebar" onclick="toggleSidebar()">☰ Menu</button>
<button class="btn">Admin</button>
</div>

<a href="add_vehicle.php" class="add-btn">Add Vehicle</a>
<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Plate</th>
<th>Driver</th>
<th>Status</th>
<th>Service</th>
<th>Last Service Date</th>
<th>Location</th>
<th>Actions</th>
</tr>

<?php while($v=mysqli_fetch_assoc($result)){ ?>
<tr>
<td><?php echo $v['id']; ?></td>
<td><?php echo htmlspecialchars($v['vehicle_name']); ?></td>
<td><?php echo htmlspecialchars($v['plate_number']); ?></td>
<td><?php echo htmlspecialchars($v['driver']); ?></td>
<td><?php echo htmlspecialchars($v['status']); ?></td>
<td><?php echo htmlspecialchars($v['service']); ?></td>
<td><?php echo htmlspecialchars($v['service_date']); ?></td>
<td><?php echo htmlspecialchars($v['location']); ?></td>
<td>
<a href="edit_vehicle.php?id=<?php echo $v['id']; ?>" class="action-btn edit-btn">Edit</a>
<a href="delete_vehicle.php?id=<?php echo $v['id']; ?>" 
   class="action-btn delete-btn"
   onclick="return confirm('Are you sure you want to delete this vehicle?');">
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