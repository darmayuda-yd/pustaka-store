<!DOCTYPE html>
<html>
<head>
    <title>Tambah Buku - Pustaka Store</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container" style="max-width: 500px;"> <h3>Input Data Buku Baru</h3>
        
        <a href="index.php" class="btn btn-back">&larr; Kembali</a>

        <form method="POST" action="">
            <table style="border: none;">
                <tr>
                    <td><label>Judul Buku</label></td>
                </tr>
                <tr>
                    <td><input type="text" name="judul" placeholder="Masukkan judul buku..." required></td>
                </tr>
                
                <tr>
                    <td><label>Penulis</label></td>
                </tr>
                <tr>
                    <td><input type="text" name="penulis" placeholder="Nama penulis..."></td>
                </tr>
                
                <tr>
                    <td><label>Harga (Rp)</label></td>
                </tr>
                <tr>
                    <td><input type="number" name="harga" placeholder="Contoh: 50000" required></td>
                </tr>
                
                <tr>
                    <td><label>Stok Awal</label></td>
                </tr>
                <tr>
                    <td><input type="number" name="stok" placeholder="Jumlah stok..." required></td>
                </tr>
                
                <tr>
                    <td>
                        <br>
                        <input type="submit" name="simpan" value="Simpan Data Buku">
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <?php
    include 'koneksi.php';
    if(isset($_POST['simpan'])){
        $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
        $penulis = mysqli_real_escape_string($koneksi, $_POST['penulis']);
        $harga = $_POST['harga'];
        $stok = $_POST['stok'];

        $insert = mysqli_query($koneksi, "INSERT INTO buku (judul, penulis, harga, stok) VALUES 
        ('$judul', '$penulis', '$harga', '$stok')");

        if($insert){
            echo "<script>alert('Data Berhasil Disimpan!');window.location='index.php';</script>";
        } else {
            echo "<script>alert('Gagal Menyimpan Data!');</script>";
        }
    }
    ?>
</body>
</html>