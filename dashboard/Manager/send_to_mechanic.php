<?php
session_start();
include("../../config/db.php");

/* AUTH CHECK */
if (!isset($_SESSION['role']) || $_SESSION['role'] != "manager") {
    header("Location: ../../auth/login.php");
    exit();
}

/* VALIDATE */
if (!isset($_GET['id']) || !isset($_GET['action'])) {
    header("Location: manage_requests.php");
    exit();
}

$id = (int) $_GET['id'];
$action = $_GET['action'];

/* =========================
   STATUS MAPPING (MANAGER FLOW)
========================= */
$map = [
    "approve" => "Approved",
    "send"    => "Sent to Mechanic",
    "reject"  => "Rejected"
];

if (!isset($map[$action])) {
    header("Location: manage_requests.php");
    exit();
}

$status = $map[$action];

/* =========================
   UPDATE REQUEST
========================= */
mysqli_query($conn, "
    UPDATE service_requests
    SET status='$status'
    WHERE id=$id
");

/* =========================
   OPTIONAL: LOGIC HOOK (for mechanic inbox later)
   (You can extend this later)
========================= */

/* REDIRECT BACK */
header("Location: manage_requests.php");
exit();
?>