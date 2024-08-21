<?php
include 'GirisKontrol.php';
// Veritabanı bağlantısını sağlayan dosyayı içe aktar
include 'database.php';

session_start();

/*
// Kullanıcı giriş yapmış mı kontrol et
if (!isset($_SESSION['adminid'])) {
    header("Location: ../adminlogin.php"); // Giriş sayfasına yönlendir
    exit();
}
*/

// Eğer form gönderildiyse
if(isset($_POST['ekle'])) {
    // Formdan gelen verileri al
    $baslik = $_POST['baslik']; // Slider başlığı
    $ozet = $_POST['ozet']; // Slider özeti
    $icerik = $_POST['icerik']; // Slider içeriği
    $tarih = $_POST['tarih']; // Slider tarihi

    // Resim dosyasını işleme
    $resimDosyasi = $_FILES['resim']['tmp_name']; // Yüklenen resmin geçici dosya adı
    $resimIcerik = file_get_contents($resimDosyasi); // Resmin içeriği

    // SQL sorgusunu hazırla
    $sorgu = "INSERT INTO slider (baslik, özet, icerik, resim, tarih) VALUES (?, ?, ?, ?, ?)";

    // Sorguyu hazırla ve bağlantıyı kullan
    $stmt = mysqli_prepare($conn, $sorgu); // Sorguyu hazırla
    if ($stmt) {
        // Değişkenleri bağla
        mysqli_stmt_bind_param($stmt, "sssss", $baslik, $ozet, $icerik, $resimIcerik, $tarih);

        // Sorguyu çalıştır
        if(mysqli_stmt_execute($stmt)) {
            echo "Yeni slider başarıyla eklendi."; // Başarı mesajı
        } else {
            echo "Slider eklenirken bir hata oluştu: " . mysqli_error($conn); // Hata mesajı
        }

        // İşlem sonrasında bağlantıyı kapat
        mysqli_stmt_close($stmt); // Sorgu bağlantısını kapat
    } else {
        echo "Sorgu hazırlanırken bir hata oluştu: " . mysqli_error($conn); // Hata mesajı
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slider Ekle</title>
    <link rel="stylesheet" href="css/AnaSayfa.css">
    <link rel="stylesheet" href="css/sliderekle.css">
    <link rel="shortcut icon" href="../images/admin-panel.png" type="image/x-icon">
</head>
<body>
<div class="sidebar">
        <div class="logo-container">
            <img src="../images/adminpanellogo.png" alt="Admin Logo" class="logo">
        </div>
        <h2>Admin Paneli</h2>
        <div class="menu">
            <ul>
                <li><a href="AnaSayfa.php">Ana Sayfa</a></li>
                <li><a href="slideryonetimi.php" class="active">Slider Yönetimi</a></li>
                <li><a href="projeyonetimi.php">Proje Yönetimi</a></li>
                <li><a href="MedyaYonetimi.php">Medya Yönetimi</a></li>
                <li><a href="HakkimizdaYonetimi.php">Hakkımızda Yönetimi</a></li>
                <li><a href="IletisimYonetimi.php">İletişim Yönetimi</a></li>
                <li class="cikisyap"><a href="adminlogout.php">Çıkış Yap</a></li>
            </ul>
        </div>
    </div>

    <div class="content">
        <h2 class="header">Slider Ekle</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <label for="baslik">Başlık:</label>
            <input type="text" id="baslik" name="baslik" required><br>

            <label for="ozet">Özet:</label>
            <textarea id="ozet" name="ozet" required></textarea><br>

            <label for="icerik">İçerik:</label>
            <textarea id="icerik" name="icerik" required></textarea><br>

            <label for="tarih">Tarih:</label>
            <input type="date" id="tarih" name="tarih" required><br><br>

            <label for="resim">Resim:</label>
            <input type="file" id="resim" name="resim" accept="image/*" required><br>

            <input type="submit" name="ekle" value="Slider Ekle">
        </form>
    </div>
</body>
</html>
