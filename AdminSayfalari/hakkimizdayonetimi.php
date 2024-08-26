<?php
include 'GirisKontrol.php';
// Veritabanı bağlantısını sağlayan dosyayı içe aktar
include 'database.php';

// Varsayılan değerler
$baslik = '';
$aciklama = '';
$resim = '';
$uyeIsim = '';
$uyeSoyisim = '';
$uyeAciklama = '';
$uyeResim = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_hakkimizda'])) {
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

        // Sayfanın yenilenmesi için yeniden yönlendirme
        header("Location: " . $_SERVER['PHP_SELF']);
        exit(); // Çıkış yaparak daha fazla kod çalıştırılmasını önleyin
    }

    if (isset($_POST['update_yonetici'])) {
        $uyeIsim = $_POST['isim'];
        $uyeSoyisim = $_POST['soyisim'];
        $uyeAciklama = $_POST['uyeAciklama'];

        // Yönetici resmi kontrol et
        if (isset($_FILES['uyeResim']) && $_FILES['uyeResim']['error'] == UPLOAD_ERR_OK) {
            $uyeResim = file_get_contents($_FILES['uyeResim']['tmp_name']);
        } else {
            // Resim seçilmediyse mevcut resmi koru
            $sql = "SELECT resim FROM yonetimekibi WHERE id = 1";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $uyeResim = $row['resim'];
            }
        }

        // Veritabanında güncelleme yap
        $sql = "UPDATE yonetimekibi SET isim = ?, soyisim = ?, aciklama = ?, resim = ? WHERE id = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $uyeIsim, $uyeSoyisim, $uyeAciklama, $uyeResim);
        $stmt->execute();
        $stmt->close();

        // Sayfanın yenilenmesi için yeniden yönlendirme
        header("Location: " . $_SERVER['PHP_SELF']);
        exit(); // Çıkış yaparak daha fazla kod çalıştırılmasını önleyin
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

    $sql = "SELECT isim, soyisim, aciklama, resim FROM yonetimekibi WHERE id = 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $uyeIsim = htmlspecialchars($row['isim']);
        $uyeSoyisim = htmlspecialchars($row['soyisim']);
        $uyeAciklama = htmlspecialchars($row['aciklama']);
        $uyeResim = $row['resim'];
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
                <li><a href="HakkimizdaYonetimi.php" class="active">Hakkımızda Yönetimi</a></li>
                <li><a href="iletisimyonetimi.php">İletişim Yönetimi</a></li>
                <li class="cikisyap"><a href="adminlogout.php">Çıkış Yap</a></li>
            </ul>
        </div>
    </div>

    <div class="content">
        <h1>Hakkımızda Yönetimi</h1>
        <!-- Hakkımızda bilgilerini düzenleme formu -->
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
            <button type="submit" name="update_hakkimizda" class="update-button">Güncelle</button>
            <?php if (isset($message)): ?>
                <p class="message"><?php echo $message; ?></p>
            <?php endif; ?>
        </form>

        <!-- Yönetici bilgilerini düzenleme formu -->
        <h1>Yönetici Bilgilerini Güncelle</h1>
        <form method="POST" enctype="multipart/form-data" class="form">
            <div class="form-group">
                <label for="isim">İsim:</label>
                <input type="text" id="isim" name="isim" value="<?php echo $uyeIsim; ?>" required>
            </div>
            <div class="form-group">
                <label for="soyisim">Soyisim:</label>
                <input type="text" id="soyisim" name="soyisim" value="<?php echo $uyeSoyisim; ?>" required>
            </div>
            <div class="form-group">
                <label for="uyeAciklama">Açıklama:</label>
                <textarea id="uyeAciklama" name="uyeAciklama" rows="4" required><?php echo $uyeAciklama; ?></textarea>
            </div>
            <div class="form-group">
                <label for="uyeResim">Resim:</label>
                <input type="file" id="uyeResim" name="uyeResim">
                <?php if ($uyeResim): ?>
                    <img class="img1" src="data:image/jpeg;base64,<?php echo base64_encode($uyeResim); ?>" alt="Mevcut Resim" style="max-width: 300px; margin-top: 10px;">
                <?php endif; ?>
            </div>
            <button type="submit" name="update_yonetici" class="update-button">Güncelle</button>
            <?php if (isset($message_yonetici)): ?>
                <p class="message"><?php echo $message_yonetici; ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
