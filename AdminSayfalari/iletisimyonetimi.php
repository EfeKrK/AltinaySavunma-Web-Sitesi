<?php
// Veritabanı bağlantısını sağlayan dosyayı içe aktar
include 'database.php';

// İletişim mesajlarını veritabanından al
$sql = "SELECT id, isim, soyisim, telefon, eposta FROM iletisim";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İletişim Yönetimi</title>
    <link rel="stylesheet" href="css/AnaSayfa.css">
    <link rel="stylesheet" href="css/iletisimYonetimi.css">
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
        <h1>İletişim Yönetimi</h1>
        <table class="message-table">
            <thead>
                <tr>
                    <th>İsim</th>
                    <th>Soyisim</th>
                    <th>Telefon</th>
                    <th>E-posta</th>
                    <th>Detaylar</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr onclick="window.location.href='iletisimDetay.php?id=<?php echo $row['id']; ?>'">
                            <td><?php echo htmlspecialchars($row['isim']); ?></td>
                            <td><?php echo htmlspecialchars($row['soyisim']); ?></td>
                            <td><?php echo htmlspecialchars($row['telefon']); ?></td>
                            <td><?php echo htmlspecialchars($row['eposta']); ?></td>
                            <td class ="detaytikla"><a href="iletisimDetay.php?id=<?php echo $row['id']; ?>">Detaylar için tıklayınız</a></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Hiç iletişim mesajı bulunamadı.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
