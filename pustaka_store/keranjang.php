<?php
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

if (isset($_POST['tambah_keranjang'])) {
    $id_buku = $_POST['id_buku'];
    
    $cek = mysqli_query($koneksi, "SELECT stok FROM buku WHERE id_buku='$id_buku'");
    $data = mysqli_fetch_assoc($cek);

    if ($data['stok'] > 0) {
        mysqli_query($koneksi, "UPDATE buku SET stok = stok - 1 WHERE id_buku='$id_buku'");

        if (isset($_SESSION['keranjang'][$id_buku])) {
            $_SESSION['keranjang'][$id_buku] += 1;
        } else {
            $_SESSION['keranjang'][$id_buku] = 1;
        }
        
        echo "<script>alert('Berhasil masuk keranjang! Stok otomatis berkurang.');location='index.php';</script>";
    } else {
        echo "<script>alert('Stok Habis! Tidak bisa menambah barang.');location='index.php';</script>";
    }
}

if (isset($_GET['aksi']) && $_GET['aksi']=='kosongkan') {
    if (!empty($_SESSION['keranjang'])) {
        foreach ($_SESSION['keranjang'] as $id_buku => $jumlah) {
           mysqli_query($koneksi, "UPDATE buku SET stok = stok + $jumlah WHERE id_buku='$id_buku'");
        }
    }
    unset($_SESSION['keranjang']);
    header("Location: keranjang.php");
}
?>

<!DOCTYPE html>
<html>
<head><title>Keranjang Belanja</title><link rel="stylesheet" href="style.css"></head>
<body>
    <nav class="navbar">
        <h1>Keranjang Belanja</h1>
        <a href="index.php">Kembali ke Katalog</a>
    </nav>
    <div class="container">
        <table>
            <thead>
                <tr><th>Buku</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th></tr>
            </thead>
            <tbody>
                <?php
                $total_belanja = 0;
                if (empty($_SESSION['keranjang'])) {
                    echo "<tr><td colspan='4' style='text-align:center'>Keranjang Kosong</td></tr>";
                } else {
                    foreach ($_SESSION['keranjang'] as $id_buku => $jumlah) {
                        $q = mysqli_query($koneksi, "SELECT * FROM buku WHERE id_buku='$id_buku'");
                        $buku = mysqli_fetch_assoc($q);
                        $subtotal = $buku['harga'] * $jumlah;
                        $total_belanja += $subtotal;
                        ?>
                        <tr>
                            <td><?php echo $buku['judul']; ?></td>
                            <td>Rp <?php echo number_format($buku['harga']); ?></td>
                            <td><?php echo $jumlah; ?></td>
                            <td>Rp <?php echo number_format($subtotal); ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Bayar</th>
                    <th>Rp <?php echo number_format($total_belanja); ?></th>
                </tr>
            </tfoot>
        </table>
        
        <?php if (!empty($_SESSION['keranjang'])): ?>
            <br>
            <a href="keranjang.php?aksi=kosongkan" class="btn btn-danger" style="width:auto;" onclick="return confirm('Yakin? Stok akan dikembalikan.')">Kosongkan & Batal</a>
            
            <a href="bayar.php" class="btn btn-success" style="width:auto; float:right;">Lanjut ke Pembayaran &rarr;</a>
        <?php endif; ?>
    </div>
</body>
</html>