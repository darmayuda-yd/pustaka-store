<?php 
include 'koneksi.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Pustaka Store</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <h1>Pustaka Store</h1>
        <div>
            <span>Halo, <b><?php echo $_SESSION['nama']; ?></b></span>
            <?php if($_SESSION['role'] == 'pembeli'): ?>
                <a href="keranjang.php">Keranjang</a>
            <?php endif; ?>
            <a href="logout.php" style="color:#ffcccc;">Logout</a>
        </div>
    </nav>

    <div class="container">
        
        <?php if ($_SESSION['role'] == 'admin'): ?>
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <h2>Kelola Buku</h2>
                <a href="tambah.php" class="btn btn-success">+ Tambah Buku</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No</th><th>Judul</th><th>Penulis</th><th>Harga</th><th>Stok</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id_buku DESC");
                    $no=1;
                    while($row = mysqli_fetch_assoc($q)){
                        echo "<tr>
                            <td>".$no++."</td>
                            <td>{$row['judul']}</td>
                            <td>{$row['penulis']}</td>
                            <td>Rp ".number_format($row['harga'])."</td>
                            
                            <td style='font-weight:bold; color:blue;'>{$row['stok']}</td>
                            
                            <td>
                                <a href='edit.php?id={$row['id_buku']}' class='btn-small btn-edit'>Edit</a>
                                
                                <a href='hapus.php?id={$row['id_buku']}' class='btn-small btn-delete' onclick='return confirm(\"Yakin ingin menghapus buku ini?\")'>Hapus</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>

        <?php else: ?>
            <h2 style="text-align:left;">Katalog Buku</h2>
            <div class="grid-container">
                <?php
                $q = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id_buku DESC");
                while($row = mysqli_fetch_assoc($q)){
                ?>
                <div class="card">
                    <div>
                        <h3><?php echo $row['judul']; ?></h3>
                        <p>Penulis: <?php echo $row['penulis']; ?></p>
                        <div class="price">Rp <?php echo number_format($row['harga']); ?></div>
                        
                        <?php if($row['stok'] > 0): ?>
                            <p>Stok: <?php echo $row['stok']; ?></p>
                        <?php else: ?>
                            <p style="color:red; font-weight:bold;">Stok: Habis</p>
                        <?php endif; ?>
                    </div>
                    
                    <?php if($row['stok'] > 0): ?>
                        <form method="POST" action="keranjang.php">
                            <input type="hidden" name="id_buku" value="<?php echo $row['id_buku']; ?>">
                            <button type="submit" name="tambah_keranjang" class="btn btn-primary">Beli Sekarang</button>
                        </form>
                    <?php else: ?>
                        <button class="btn" style="background-color:#ccc; cursor:not-allowed;" disabled>Stok Habis</button>
                    <?php endif; ?>
                </div>
                <?php } ?>
            </div>
        <?php endif; ?>
        
    </div>
</body>
</html>