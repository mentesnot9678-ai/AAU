<?php
session_start();
include("../config/db.php");

// Admin only
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_GET['id'])) {

    $id = (int)$_GET['id'];

    mysqli_query($conn,
        "UPDATE users
         SET status='active'
         WHERE id=$id"
    );
}

header("Location: admin.php");
exit();
?>