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

    // prevent self delete
    if ($id != $_SESSION['user_id']) {

        mysqli_query($conn,
            "DELETE FROM users WHERE id=$id"
        );
    }
}

header("Location: admin.php");
exit();
?>