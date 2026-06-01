<?php
session_start();
include("../config/db.php");

// Only admin can access
if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    header("Location: ../auth/login.php");
    exit();
}

/* USERS */
$users = mysqli_query($conn,"
    SELECT id, username, email, role, status, created_at
    FROM users
    ORDER BY id DESC
");

/* CONTACT MESSAGES */
$contacts = mysqli_query($conn,"
    SELECT *
    FROM contact
    ORDER BY id DESC
");

/* COUNTS */
$total_users = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) AS cnt FROM users"
))['cnt'];

$active_users = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) AS cnt FROM users WHERE status='active'"
))['cnt'];

$inactive_users = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) AS cnt FROM users WHERE status='inactive'"
))['cnt'];

$total_messages = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) AS cnt FROM contact"
))['cnt'];

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>

<style>

/* ================= GLOBAL ================= */
body{
    margin:0;
    font-family:Arial, sans-serif;
    background:#0f172a;
    color:#fff;
    display:flex;
}

/* ================= SIDEBAR ================= */
.sidebar{
    width:240px;
    height:100vh;
    background:#111827;
    padding:20px;
    position:fixed;
    left:0;
    top:0;
}

.sidebar h2{
    color:#00f7ff;
    text-align:center;
    margin-bottom:30px;
}

.sidebar a{
    display:block;
    padding:12px;
    margin:10px 0;
    color:#fff;
    text-decoration:none;
    border-radius:8px;
    transition:0.3s;
    background:#1f2937;
}

.sidebar a:hover{
    background:#00f7ff;
    color:#000;
}

/* ================= MAIN ================= */
.main{
    margin-left:260px;
    padding:30px;
    width:100%;
}

/* ================= CARDS ================= */
.cards{
    display:flex;
    gap:20px;
    margin-bottom:30px;
}

.card{
    flex:1;
    background:#1f2937;
    padding:20px;
    border-radius:12px;
    text-align:center;
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
    background:#273244;
}

.card h3{
    margin:0;
    font-size:16px;
    color:#aaa;
}

.card p{
    font-size:32px;
    margin:10px 0 0;
    color:#00f7ff;
    font-weight:bold;
}

/* ================= TABLE ================= */
table{
    width:100%;
    border-collapse:collapse;
    background:#1f2937;
    border-radius:10px;
    overflow:hidden;
    margin-bottom:30px;
}

th,td{
    padding:12px;
    text-align:left;
    border-bottom:1px solid #2d3748;
}

th{
    background:#00f7ff;
    color:#000;
}

tr:hover{
    background:#273244;
}

/* ================= BUTTONS ================= */
.edit-btn,
.deactivate-btn,
.activate-btn,
.delete-btn{
    padding:6px 10px;
    border-radius:6px;
    text-decoration:none;
    margin-right:5px;
    display:inline-block;
    font-size:12px;
}

.edit-btn{ background:#3b82f6; color:#fff; }
.deactivate-btn{ background:#ef4444; color:#fff; }
.activate-btn{ background:#22c55e; color:#000; }
.delete-btn{ background:#111; color:#fff; }

.edit-btn:hover,
.deactivate-btn:hover,
.activate-btn:hover,
.delete-btn:hover{
    opacity:0.8;
}

/* ================= STATUS ================= */
.active-status{ color:#22c55e; font-weight:bold; }
.inactive-status{ color:#ef4444; font-weight:bold; }

</style>

</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>AAU VMS</h2>

    <a href="admin.php">Dashboard</a>
    <a href="add_user.php">Create User</a>
    <a href="../auth/logout.php">Logout</a>
</div>

<!-- MAIN -->
<div class="main">

    <h1>User Management Dashboard</h1>

    <!-- STATS -->
    <div class="cards">

        <div class="card">
            <h3>Total Users</h3>
            <p><?php echo $total_users; ?></p>
        </div>

        <div class="card">
            <h3>Active Users</h3>
            <p><?php echo $active_users; ?></p>
        </div>

        <div class="card">
            <h3>Inactive Users</h3>
            <p><?php echo $inactive_users; ?></p>
        </div>

        <div class="card">
            <h3>Messages</h3>
            <p><?php echo $total_messages; ?></p>
        </div>

    </div>

    <!-- USERS TABLE -->
    <h2>Manage Users</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Created</th>
            <th>Actions</th>
        </tr>

        <?php while($user = mysqli_fetch_assoc($users)): ?>

        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo htmlspecialchars($user['username']); ?></td>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
            <td><?php echo htmlspecialchars($user['role']); ?></td>

            <td>
                <?php if($user['status'] == 'active'): ?>
                    <span class="active-status">Active</span>
                <?php else: ?>
                    <span class="inactive-status">Inactive</span>
                <?php endif; ?>
            </td>

            <td><?php echo $user['created_at']; ?></td>

            <td>
                <a class="edit-btn" href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a>

                <?php if($user['status'] == 'active'): ?>
                    <a class="deactivate-btn" href="deactivate_user.php?id=<?php echo $user['id']; ?>">Deactivate</a>
                <?php else: ?>
                    <a class="activate-btn" href="activate_user.php?id=<?php echo $user['id']; ?>">Activate</a>
                <?php endif; ?>

                <a class="delete-btn" href="delete_user.php?id=<?php echo $user['id']; ?>">Delete</a>
            </td>
        </tr>

        <?php endwhile; ?>

    </table>

    <!-- CONTACT MESSAGES TABLE -->
    <h2>Contact Messages</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Message</th>
        </tr>

        <?php while($msg = mysqli_fetch_assoc($contacts)): ?>

        <tr>
            <td><?php echo $msg['id']; ?></td>
            <td><?php echo htmlspecialchars($msg['first_name']); ?></td>
            <td><?php echo htmlspecialchars($msg['last_name']); ?></td>
            <td><?php echo htmlspecialchars($msg['subject']); ?></td>
        </tr>

        <?php endwhile; ?>

    </table>

</div>

</body>
</html>