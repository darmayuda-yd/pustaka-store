<?php
include 'koneksi.php';
$step = 1; 
$error = "";
$success = "";

if (isset($_POST['cek_user'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);

    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND email='$email'");
    
    if (mysqli_num_rows($cek) > 0) {
        $step = 2; 
        $data = mysqli_fetch_assoc($cek);
        $id_user_reset = $data['id_user']; 
        $error = "Username atau Email tidak ditemukan/tidak cocok!";
    }
}

if (isset($_POST['reset_pass'])) {
    $id_user = $_POST['id_user'];
    $pass_baru = $_POST['pass_baru'];
    $konfirmasi = $_POST['konfirmasi_pass'];

    if ($pass_baru == $konfirmasi) {
        $password_hash = password_hash($pass_baru, PASSWORD_DEFAULT);
        
        $update = mysqli_query($koneksi, "UPDATE users SET password='$password_hash' WHERE id_user='$id_user'");
        
        if ($update) {
            $success = "Password berhasil diubah! Silakan login.";
            $step = 3; 
        } else {
            $error = "Gagal mengupdate database.";
            $step = 2; 
        }
    } else {
        $error = "Konfirmasi password tidak sama!";
        $step = 2; 
        $id_user_reset = $id_user; 
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lupa Password - Pustaka Store</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .auth-box { margin-top: 50px; }
        .alert { padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 0.9rem; }
        .alert-danger { background: #ffebee; color: #c62828; border: 1px solid #ef9a9a; }
        .alert-success { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
    </style>
</head>
<body>
    <div class="auth-box">
        <h2 style="text-align:center;">Reset Password</h2>
        
        <?php if($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <?php if($step == 1): ?>
            <p style="text-align:center; color:#666;">Masukkan Username dan Email Anda yang terdaftar.</p>
            <form method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" required placeholder="Contoh: admin">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required placeholder="Contoh: admin@mail.com">
                </div>
                <button type="submit" name="cek_user" class="btn btn-primary">Cek Akun</button>
            </form>
            <p style="text-align:center; margin-top:15px;">
                <a href="login.php">Kembali ke Login</a>
            </p>

        <?php elseif($step == 2): ?>
            <p style="text-align:center; color:#666;">Akun ditemukan! Masukkan password baru.</p>
            <form method="POST">
                <input type="hidden" name="id_user" value="<?php echo $id_user_reset; ?>">
                
                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" name="pass_baru" required placeholder="Minimal 3 karakter">
                </div>
                <div class="form-group">
                    <label>Ulangi Password Baru</label>
                    <input type="password" name="konfirmasi_pass" required>
                </div>
                <button type="submit" name="reset_pass" class="btn btn-primary">Ubah Password</button>
            </form>

        <?php elseif($step == 3): ?>
            <div style="text-align:center;">
                <p>Password Anda telah diperbarui.</p>
                <a href="login.php" class="btn btn-success">Login Sekarang</a>
            </div>
        <?php endif; ?>

    </div>
</body>
</html>