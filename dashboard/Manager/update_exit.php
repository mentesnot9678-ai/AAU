<?php
session_start();
include("../../config/db.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] != "manager") {
    header("Location: ../../auth/login.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['status'])) {

    $id = (int)$_GET['id'];
    $status = mysqli_real_escape_string($conn, $_GET['status']);

    mysqli_query($conn, "
        UPDATE exit_requests
        SET status='$status'
        WHERE id=$id
    ");
}

header("Location: manage_exit_requests.php");
exit();
?>