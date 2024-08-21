<?php
include 'GirisKontrol.php';
// Veritabanı bağlantısını sağlayan dosyayı içe aktar
include 'database.php';

// Form gönderildiğinde verileri işleyin
$alertMessage = '';
$alertType = '';

if (isset($_POST['ekle'])) {
    // Formdan gelen verileri al
    $baslik = $_POST['baslik'];
    $özet = $_POST['özet'];
    $içerik = $_POST['içerik'];
    $tarih = $_POST['tarih'];

    // Resim dosyasını kontrol et
    if (isset($_FILES['resim']) && $_FILES['resim']['error'] == 0) {
        // Dosyayı oku
        $resim = file_get_contents($_FILES['resim']['tmp_name']);

        // SQL sorgusunu hazırla
        $sql = "INSERT INTO kartlar (baslik, özet, içerik, resim, tarih) VALUES (?, ?, ?, ?, ?)";

        // SQL sorgusunu hazırla ve çalıştır
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssss", $baslik, $özet, $içerik, $resim, $tarih);
            if ($stmt->execute()) {
                $alertMessage = "Medya başarıyla eklendi!";
                $alertType = 'success';
            } else {
                $alertMessage = "Hata: " . $stmt->error;
                $alertType = 'error';
            }
            $stmt->close();
        } else {
            $alertMessage = "Hata: " . $conn->error;
            $alertType = 'error';
        }
    } else {
        $alertMessage = "Resim dosyası yüklenirken bir hata oluştu.";
        $alertType = 'error';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/AnaSayfa.css">
    <link rel="stylesheet" href="css/medyaekle.css">
    <link rel="shortcut icon" href="../images/admin-panel.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
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
                <li><a href="MedyaYonetimi.php" class="active">Medya Yönetimi</a></li>
                <li><a href="HakkimizdaYonetimi.php">Hakkımızda Yönetimi</a></li>
                <li><a href="IletisimYonetimi.php">İletişim Yönetimi</a></li>
                <li class="cikisyap"><a href="adminlogout.php">Çıkış Yap</a></li>
            </ul>
        </div>
    </div>

    <div class="content">
        <h2 class="header">Medya Ekle</h2>
        <form id="MediaForm" method="POST" action="" enctype="multipart/form-data">
            <label for="baslik">Medya ismi:</label>
            <input type="text" id="baslik" name="baslik" required><br>

            <label for="içerik">İçerik:</label>
            <textarea id="içerik" name="içerik" required></textarea><br>

            <label for="özet">Özet:</label>
            <textarea id="özet" name="özet"></textarea><br>

            <label for="tarih">Tarih:</label>
            <input type="date" id="tarih" name="tarih" required><br><br>

            <label for="resim">Resim:</label>
            <input type="file" id="resim" name="resim" accept="image/*" required>

            <input type="submit" name="ekle" value="Medya Ekle">
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                <?php if (!empty($alertMessage)): ?>
                    Swal.fire({
                        icon: '<?php echo $alertType; ?>',
                        title: '<?php echo ucfirst($alertType); ?>',
                        text: '<?php echo addslashes($alertMessage); ?>',
                        confirmButtonText: 'Tamam'
                    }).then(function() {
                        <?php if ($alertType === 'success'): ?>
                            window.location.href = 'MedyaYonetimi.php'; // Başarı mesajı gösterildikten sonra yönlendirilecek sayfa
                        <?php endif; ?>
                    });
                <?php endif; ?>
            });
        </script>
    </div>
</body>
</html>
