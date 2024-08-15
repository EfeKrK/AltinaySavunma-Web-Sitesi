<?php
// Veritabanı bağlantısını sağlayan dosyayı içe aktar
include 'database.php';

// Varsayılan değerler
$baslik = '';
$aciklama = '';
$resim = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        $baslik = $_POST['baslik'];
        $aciklama = $_POST['aciklama'];

        // Resim dosyasını kontrol et
        if (isset($_FILES['resim']) && $_FILES['resim']['error'] == UPLOAD_ERR_OK) {
            $resim = file_get_contents($_FILES['resim']['tmp_name']);
        } else {
            // Resim seçilmediyse mevcut resmi koru
            $sql = "SELECT resim FROM hakkimizda LIMIT 1";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $resim = $row['resim'];
            }
        }

        // Veritabanında güncelleme yap
        $sql = "UPDATE hakkimizda SET baslik = ?, aciklama = ?, resim = ? WHERE id = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $baslik, $aciklama, $resim);
        $stmt->execute();
        $stmt->close();

        $message = "Güncellemeler başarıyla kaydedildi!";
    }
} else {
    // Sayfa yüklendiğinde mevcut verileri al
    $sql = "SELECT baslik, aciklama, resim FROM hakkimizda LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $baslik = htmlspecialchars($row['baslik']);
        $aciklama = htmlspecialchars($row['aciklama']);
        $resim = $row['resim'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hakkımızda Yönetimi</title>
    <link rel="stylesheet" href="css/AnaSayfa.css">
    <link rel="stylesheet" href="css/hakkimizdayonetim.css">
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
                <li><a href="HakkimizdaYonetimi.php" class="active">Hakkımızda Yönetimi</a></li>
                <li><a href="iletisimyonetimi.php">İletişim Yönetimi</a></li>
                <li class="cikisyap"><a href="adminlogout.php">Çıkış Yap</a></li>
            </ul>
        </div>
    </div>

    <div class="content">
        <h1>Hakkımızda Yönetimi</h1>
        <form method="POST" enctype="multipart/form-data" class="form">
            <div class="form-group">
                <label for="baslik">Başlık:</label>
                <input type="text" id="baslik" name="baslik" value="<?php echo $baslik; ?>" required>
            </div>
            <div class="form-group">
                <label for="aciklama">Açıklama:</label>
                <textarea id="aciklama" name="aciklama" rows="4" required><?php echo $aciklama; ?></textarea>
            </div>
            <div class="form-group">
                <label for="resim">Resim:</label>
                <input type="file" id="resim" name="resim">
                <?php if ($resim): ?>
                    <img class="img1" src="data:image/jpeg;base64,<?php echo base64_encode($resim); ?>" alt="Mevcut Resim" style="max-width: 300px; margin-top: 10px;">
                <?php endif; ?>
            </div>
            <button type="submit" name="update" class="update-button">Güncelle</button>
            <?php if (isset($message)): ?>
                <p class="message"><?php echo $message; ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
