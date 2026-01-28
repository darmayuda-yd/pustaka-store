<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$id_buku = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM buku WHERE id_buku='$id_buku'");
$data = mysqli_fetch_assoc($query);

if (isset($_POST['update'])) {
    $judul   = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $harga   = $_POST['harga'];
    $stok    = $_POST['stok'];

    $update = mysqli_query($koneksi, "UPDATE buku SET 
        judul='$judul', 
        penulis='$penulis', 
        harga='$harga', 
        stok='$stok' 
        WHERE id_buku='$id_buku'");

    if ($update) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal update data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Buku</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container" style="max-width: 500px;">
        <h3>Edit Data Buku</h3>
        <a href="index.php" class="btn btn-back">&larr; Kembali</a>

        <form method="POST">
            <table style="border:none;">
                <tr>
                    <td><label>Judul Buku</label></td>
                </tr>
                <tr>
                    <td><input type="text" name="judul" value="<?php echo $data['judul']; ?>" required></td>
                </tr>

                <tr>
                    <td><label>Penulis</label></td>
                </tr>
                <tr>
                    <td><input type="text" name="penulis" value="<?php echo $data['penulis']; ?>"></td>
                </tr>

                <tr>
                    <td><label>Harga (Rp)</label></td>
                </tr>
                <tr>
                    <td><input type="number" name="harga" value="<?php echo $data['harga']; ?>" required></td>
                </tr>

                <tr>
                    <td><label>Stok Barang</label></td>
                </tr>
                <tr>
                    <td><input type="number" name="stok" value="<?php echo $data['stok']; ?>" required></td>
                </tr>

                <tr>
                    <td>
                        <br>
                        <button type="submit" name="update" class="btn btn-success" style="width:100%">Simpan Perubahan</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>