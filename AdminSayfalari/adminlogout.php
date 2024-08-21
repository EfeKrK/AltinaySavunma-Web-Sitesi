<?php
session_start();
session_unset(); // Tüm oturum değişkenlerini temizle
session_destroy(); // Oturumu sonlandır
header("Location: loginsayfasi.php"); // Login sayfasına yönlendir
exit();
?>