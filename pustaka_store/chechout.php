<?php
include 'koneksi.php';
if (empty($_SESSION['keranjang']) OR !isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$id_user = $_SESSION['user_id'];
$total_bayar = 0;

foreach ($_SESSION['keranjang'] as $id_buku => $jumlah) {
    $q = mysqli_query($koneksi, "SELECT harga FROM buku WHERE id_buku='$id_buku'");
    $buku = mysqli_fetch_assoc($q);
    $total_bayar += ($buku['harga'] * $jumlah);
}

$query_pesanan = "INSERT INTO pesanan (id_user, total_bayar) VALUES ('$id_user', '$total_bayar')";
mysqli_query($koneksi, $query_pesanan);
$id_pesanan_baru = mysqli_insert_id($koneksi); 

foreach ($_SESSION['keranjang'] as $id_buku => $jumlah) {
    $q = mysqli_query($koneksi, "SELECT harga FROM buku WHERE id_buku='$id_buku'");
    $buku = mysqli_fetch_assoc($q);
    $subtotal = $buku['harga'] * $jumlah;

    mysqli_query($koneksi, "INSERT INTO detail_pesanan (id_pesanan, id_buku, jumlah, subtotal) 
                            VALUES ('$id_pesanan_baru', '$id_buku', '$jumlah', '$subtotal')");
    
    mysqli_query($koneksi, "UPDATE buku SET stok = stok - $jumlah WHERE id_buku='$id_buku'");
}

unset($_SESSION['keranjang']);

echo "<script>alert('Pembelian Berhasil! Pesanan ID: $id_pesanan_baru');location='index.php';</script>";
?>