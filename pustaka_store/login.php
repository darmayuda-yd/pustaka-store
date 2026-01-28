<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Pustaka Store</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="auth-box">
        <h2 style="text-align:center;">Login Pustaka Store</h2>
        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary">Masuk</button>
            <div style="text-align:right; margin-top: 5px;">
                <a href="lupa_password.php" style="font-size:0.9rem; color:#4e54c8;">Lupa Password?</a>
            </div>
        </form>
        <p style="text-align:center; margin-top:15px;">
            Belum punya akun? <a href="register.php">Daftar disini</a>
        </p>
    </div>
</body>
</html>

<?php
if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
    if(mysqli_num_rows($cek) > 0){
        $data = mysqli_fetch_assoc($cek);
        if(password_verify($password, $data['password'])){
            $_SESSION['user_id'] = $data['id_user'];
            $_SESSION['nama'] = $data['nama_lengkap'];
            $_SESSION['role'] = $data['role'];
            echo "<script>location='index.php';</script>";
        } else {
            echo "<script>alert('Password salah!');</script>";
        }
    } else {
        echo "<script>alert('Username tidak ditemukan!');</script>";
    }
}
?>