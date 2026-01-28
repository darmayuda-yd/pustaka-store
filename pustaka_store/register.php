<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Akun - Pustaka Store</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="auth-box">
        <h2 style="text-align:center;">Daftar Akun Baru</h2>
        
        <form method="POST">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" required placeholder="Contoh: Budi Santoso">
            </div>
            
            <div class="form-group">
                <label>Alamat Email</label>
                <input type="email" name="email" required placeholder="Contoh: budi@gmail.com">
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="user" required placeholder="Tanpa spasi">
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="pass" required>
            </div>
            
            <button type="submit" name="daftar" class="btn btn-primary">Daftar Sekarang</button>
        </form>
        
        <p style="text-align:center;">
            Sudah punya akun? <a href="login.php">Login disini</a>
        </p>
    </div>
</body>
</html>

<?php
if(isset($_POST['daftar'])){
    $nama  = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $user  = mysqli_real_escape_string($koneksi, $_POST['user']);
    $pass  = password_hash($_POST['pass'], PASSWORD_DEFAULT); 
    $role  = 'pembeli'; 
    
    $sql = "INSERT INTO users (nama_lengkap, email, username, password, role) 
            VALUES ('$nama', '$email', '$user', '$pass', '$role')";

    if(mysqli_query($koneksi, $sql)){
        echo "<script>
            alert('Pendaftaran Sukses! Silakan Login.');
            location='login.php';
        </script>";
    } else {
         echo "<script>alert('Gagal Daftar: Username atau Email mungkin sudah digunakan!');</script>";
    }
}
?>