<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id']) OR empty($_SESSION['keranjang'])) {
    header("Location: index.php");
    exit();
}

$total_belanja = 0;
foreach ($_SESSION['keranjang'] as $id_buku => $jumlah) {
    $q = mysqli_query($koneksi, "SELECT harga FROM buku WHERE id_buku='$id_buku'");
    $d = mysqli_fetch_assoc($q);
    $total_belanja += ($d['harga'] * $jumlah);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran - Pustaka Store</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .payment-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            align-items: center;
        }
        .payment-box:hover { border-color: var(--primary); background: #f9f9ff; }
        .payment-box input { margin-right: 15px; transform: scale(1.5); }
        .total-section { font-size: 1.5rem; font-weight: bold; color: var(--primary); margin: 20px 0; }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>Pustaka Store</h1>
    </nav>

    <div class="container" style="max-width: 600px;">
        <h2>Konfirmasi Pembayaran</h2>
        
        <div class="card">
            <p>Total yang harus dibayarkan:</p>
            <div class="total-section">Rp <?php echo number_format($total_belanja); ?></div>

            <form method="POST" action="proses_bayar.php">
                <p><b>Pilih Metode Pembayaran:</b></p>

                <label class="payment-box">
                    <input type="radio" name="metode" value="Transfer Bank BCA" required>
                    <div>
                        <b>Transfer Bank BCA</b><br>
                        <small>No. Rek: 123-456-7890 (a.n Pustaka Store)</small>
                    </div>
                </label>

                <label class="payment-box">
                    <input type="radio" name="metode" value="Transfer Bank BRI">
                    <div>
                        <b>Transfer Bank BRI</b><br>
                        <small>No. Rek: 9876-5432-100 (a.n Pustaka Store)</small>
                    </div>
                </label>

                <label class="payment-box">
                    <input type="radio" name="metode" value="Dana / GoPay">
                    <div>
                        <b>E-Wallet (Dana/GoPay)</b><br>
                        <small>Scan QRIS pada langkah selanjutnya</small>
                    </div>
                </label>

                <label class="payment-box">
                    <input type="radio" name="metode" value="COD">
                    <div>
                        <b>Bayar Ditempat (COD)</b><br>
                        <small>Bayar tunai saat kurir datang</small>
                    </div>
                </label>

                <br>
                <button type="submit" name="bayar" class="btn btn-primary">Bayar Sekarang</button>
                <a href="keranjang.php" class="btn btn-danger" style="text-decoration:none; display:inline-block; text-align:center;">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>