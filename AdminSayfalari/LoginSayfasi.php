<?php
session_start();
include('database.php'); // Veritabanı bağlantısı

$login_success = false;
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kullaniciadi = $_POST['kullaniciadi'];
    $sifre = $_POST['sifre'];

    // SQL sorgusu
    $sql = "SELECT id FROM admins WHERE kullaniciadi = ? AND sifre = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $kullaniciadi, $sifre);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        // Kullanıcı bulundu
        $stmt->bind_result($id);
        $stmt->fetch();
        
        // Oturumu başlat ve kullanıcı id'sini sakla
        $_SESSION['kullanici_id'] = $id;
        $login_success = true;
    } else {
        $error = "Kullanıcı adı veya şifre yanlış!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/Login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="wrapper">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="logo"><img src="../images/Ornek.png" alt=""></div>
            <hr class="cizgi">
            <h1>Admin Girişi</h1>
             
            <div class="input-box">
                <input type="text" name="kullaniciadi" placeholder="Kullanıcı Adı" required>
                <i class='bx bxs-user'></i>
            </div>

            <div class="input-box">
                <input type="password" name="sifre" placeholder="Şifre" required>
                <i class='bx bxs-lock-alt'></i>
            </div>

            <div class="remember-forgot">
                <label><input type="checkbox" class="checkbox-remember">Remember Me</label>
                <a href="#">Şifremi Unuttum</a>
            </div>

            <button type="submit" class="btn">Giriş Yap</button>
        </form>
    </div>

    <?php if ($login_success): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Giriş Başarılı!',
                text: 'Yönlendiriliyorsunuz...',
                timer: 2000,
                showConfirmButton: false
            }).then(function() {
                window.location.href = 'AnaSayfa.php';
            });
        </script>
    <?php elseif ($error): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Giriş Başarısız!',
                text: '<?php echo $error; ?>',
                showConfirmButton: true
            });
        </script>
    <?php endif; ?>
</body>
</html>
