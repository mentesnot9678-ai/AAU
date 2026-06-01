<?php
session_start();

require_once __DIR__ . '/../../config/db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != "manager"){
    header("Location: ../auth/login.php");
    exit();
}

// CHECK IF ID EXISTS
if(!isset($_GET['id']) || empty($_GET['id'])){
    header("Location: trips.php");
    exit();
}

// SAFE INTEGER CAST
$id = (int) $_GET['id'];

// RUN DELETE SAFELY
$sql = "DELETE FROM trips WHERE id=$id";

if(mysqli_query($conn, $sql)){
    header("Location: trips.php");
    exit();
} else {
    die("Delete failed: " . mysqli_error($conn));
}
?>