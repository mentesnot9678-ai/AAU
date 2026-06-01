<?php
session_start();
include("../../config/db.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] != "manager") {
    header("Location: ../../auth/login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: manage_requests.php");
    exit();
}

$id = (int)$_GET['id'];

/* UPDATE STATUS */
mysqli_query($conn, "
    UPDATE service_requests
    SET status='Rejected'
    WHERE id=$id
");

/* REDIRECT BACK */
header("Location: manage_requests.php");
exit();
?>