<?php
include 'koneksi.php';

$password_baru = "123";
$password_hash = password_hash($password_baru, PASSWORD_DEFAULT);

$username = "admin";
$query = "UPDATE users SET password='$password_hash' WHERE username='$username'";

if(mysqli_query($koneksi, $query)){
    echo "<h1>Berhasil!</h1>";
    echo "Password untuk user <b>'admin'</b> berhasil direset menjadi <b>'123'</b>.<br>";
    echo "Silakan <a href='login.php'>Login Disini</a>";
} else {
    echo "Gagal: " . mysqli_error($koneksi);
}
?>