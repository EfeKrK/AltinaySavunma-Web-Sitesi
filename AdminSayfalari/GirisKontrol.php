
<?php
session_start();
if (!isset($_SESSION['kullanici_id'])) {
    header("Location: LoginSayfasi.php"); // Giriş yapmadan erişilirse login sayfasına yönlendir
    exit();
}

?>