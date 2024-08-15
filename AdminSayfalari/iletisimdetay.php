<?php
// Veritabanı bağlantısını sağlayan dosyayı içe aktar
include 'database.php';

// Mesaj detaylarını almak için ID'yi kontrol et
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Veritabanından mesajı al
    $sql = "SELECT * FROM iletisim WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $message = $result->fetch_assoc();
} else {
    // ID verilmemişse veya geçersizse yönlendirme
    header("Location: iletisimYonetimi.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesaj Detayı</title>
    <link rel="stylesheet" href="css/AnaSayfa.css">
    <link rel="stylesheet" href="css/iletisimDetay.css">
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
                <li><a href="slideryonetimi.php">Slider Yönetimi</a></li>
                <li><a href="projeyonetimi.php">Proje Yönetimi</a></li>
                <li><a href="MedyaYonetimi.php">Medya Yönetimi</a></li>
                <li><a href="HakkimizdaYonetimi.php">Hakkımızda Yönetimi</a></li>
                <li><a href="iletisimYonetimi.php" class="active">İletişim Yönetimi</a></li>
                <li class="cikisyap"><a href="adminlogout.php">Çıkış Yap</a></li>
            </ul>
        </div>
    </div>

    <div class="content">
        <h1>Mesaj Detayı</h1>
        <div class="message-details">
            <p><strong>İsim:</strong> <?php echo htmlspecialchars($message['isim']); ?></p>
            <p><strong>Soyisim:</strong> <?php echo htmlspecialchars($message['soyisim']); ?></p>
            <p><strong>Şirket:</strong> <?php echo htmlspecialchars($message['sirket']); ?></p>
            <p><strong>Pozisyon:</strong> <?php echo htmlspecialchars($message['pozisyon']); ?></p>
            <p><strong>Telefon:</strong> <?php echo htmlspecialchars($message['telefon']); ?></p>
            <p><strong>E-posta:</strong> <?php echo htmlspecialchars($message['eposta']); ?></p>
            <p><strong>Mesaj:</strong> <?php echo nl2br(htmlspecialchars($message['mesaj'])); ?></p>
        </div>
    </div>
</body>
</html>
