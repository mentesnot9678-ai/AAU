<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../auth/login.php");
    exit();
}

$id = (int)($_GET['id'] ?? 0);

if($id > 0){
    mysqli_query($conn,"DELETE FROM maintenance WHERE id=$id");
}

header("Location: maintenance.php");
exit();