<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM buku WHERE id_buku='$id'");

header("Location: index.php");
?>