<?php
session_start();
include("../../config/db.php");

header('Content-Type: application/json');

if (!isset($_SESSION['role']) || $_SESSION['role'] != "driver") {
    echo json_encode([]);
    exit();
}

$username = $_SESSION['username'];

$result = mysqli_query($conn, "SELECT * FROM trips WHERE driver='$username' ORDER BY id DESC");

$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
?>