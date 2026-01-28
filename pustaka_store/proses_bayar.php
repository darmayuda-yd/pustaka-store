<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id']) OR empty($_SESSION['keranjang'])) {
    header("Location: index.php");
    exit();
}

$id_user = $_SESSION['user_id'];
$metode = $_POST['metode']; 
$total_bayar = 0;

foreach ($_SESSION['keranjang'] as $id_buku => $jumlah) {
    $q = mysqli_query($koneksi, "SELECT harga FROM buku WHERE id_buku='$id_buku'");
    $buku = mysqli_fetch_assoc($q);
    $total_bayar += ($buku['harga'] * $jumlah);
}

$query_pesanan = "INSERT INTO pesanan (id_user, total_bayar, metode_pembayaran, tanggal_pesan) 
                  VALUES ('$id_user', '$total_bayar', '$metode', NOW())";

if (mysqli_query($koneksi, $query_pesanan)) {
    $id_pesanan_baru = mysqli_insert_id($koneksi);

    foreach ($_SESSION['keranjang'] as $id_buku => $jumlah) {
        $q = mysqli_query($koneksi, "SELECT harga FROM buku WHERE id_buku='$id_buku'");
        $buku = mysqli_fetch_assoc($q);
        $subtotal = $buku['harga'] * $jumlah;

        mysqli_query($koneksi, "INSERT INTO detail_pesanan (id_pesanan, id_buku, jumlah, subtotal) 
                                VALUES ('$id_pesanan_baru', '$id_buku', '$jumlah', '$subtotal')");
        
    }

    unset($_SESSION['keranjang']);

    echo "<script>
        alert('Pembayaran Berhasil! Stok sudah update.');
        location='index.php';
    </script>";

} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>