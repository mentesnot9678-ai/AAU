<?php
session_start();
include("../../config/db.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] != "driver") {
    header("Location: ../../auth/login.php");
    exit();
}

if (!isset($_POST['trip_id']) || !is_numeric($_POST['trip_id'])) {
    header("Location: index.php");
    exit();
}

$trip_id = (int) $_POST['trip_id'];

/* Get current status */
$q = mysqli_query($conn, "SELECT status FROM trips WHERE id=$trip_id LIMIT 1");

if (!$q || mysqli_num_rows($q) == 0) {
    header("Location: index.php");
    exit();
}

$row = mysqli_fetch_assoc($q);

/* Normalize status */
$status = strtolower(trim($row['status']));

/* =========================
   STATUS FLOW (FORCE FIX)
========================= */

/* STEP 1: ANY pending type → In Progress */
if (
    $status == "pending" ||
    $status == "pending staff approval" ||
    $status == "approved"
) {
    mysqli_query($conn, "
        UPDATE trips 
        SET status='In Progress'
        WHERE id=$trip_id
    ");
}

/* STEP 2: In Progress → Completed */
elseif ($status == "in progress") {
    mysqli_query($conn, "
        UPDATE trips 
        SET status='Completed'
        WHERE id=$trip_id
    ");
}

/* STEP 3: Completed or Rejected → NO CHANGE */
else {
    // do nothing
}

header("Location: index.php");
exit();
?>