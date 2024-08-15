<?php
// Veritabanı bağlantısını sağlayan dosyayı içe aktar
include 'database.php';

// Silme işlemi
$alertMessage = '';
$alertType = '';

if (isset($_POST['delete'])) {
    if (!empty($_POST['ids'])) {
        $idsToDelete = $_POST['ids'];
        $ids = implode(',', array_map('intval', $idsToDelete));
        $sql = "DELETE FROM kartlar WHERE id IN ($ids)";
        if ($conn->query($sql) === TRUE) {
            $alertMessage = "Seçili medya başarıyla silindi!";
            $alertType = 'success';
        } else {
            $alertMessage = "Hata: " . $conn->error;
            $alertType = 'error';
        }
    }
}

// Kartları veritabanından al
$sql = "SELECT id, baslik, özet, içerik, resim, tarih FROM kartlar";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/AnaSayfa.css">
    <link rel="stylesheet" href="css/medyaYonetimi.css">
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
                <li><a href="medyaYonetimi.php" class="active">Medya Yönetimi</a></li>
                <li><a href="HakkimizdaYonetimi.php">Hakkımızda Yönetimi</a></li>
                <li><a href="IletisimYonetimi.php">İletişim Yönetimi</a></li>
                <li class="cikisyap"><a href="adminlogout.php">Çıkış Yap</a></li>
            </ul>
        </div>
    </div>

    <div class="medya-content">
        <h1>Medya Yönetimi</h1>
        <form method="POST" action="" id="medyaForm">
            <div class="medya-list">
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="medya-card">
                            <div class="medya-slider">
                                <div class="medya-images">
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row['resim']); ?>" alt="Medya Resmi">
                                </div>
                            </div>
                            <div class="medya-details">
                                <h2><?php echo htmlspecialchars($row['baslik']); ?></h2>
                                <p><strong>Özet:</strong> <?php echo nl2br(htmlspecialchars($row['özet'])); ?></p>
                                <?php if ($row['içerik']): ?>
                                    <p><strong>İçerik:</strong> <?php echo nl2br(htmlspecialchars($row['içerik'])); ?></p>
                                <?php endif; ?>
                                <p><strong>Tarih:</strong> <?php echo htmlspecialchars($row['tarih']); ?></p>
                                <input type="checkbox" name="ids[]" value="<?php echo $row['id']; ?>">
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Hiç medya bulunamadı.</p>
                <?php endif; ?>
            </div>
            <button type="submit" name="delete" class="delete-button">Sil Seçilenler</button>
            <a href="medyaEkle.php" class="add-button">Yeni Ekle</a>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.medya-card');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add('visible');
            }, index * 200); // Kartların yavaşça görünmesini sağlar
        });

        // SweetAlert ile başarı mesajını göster
        <?php if (!empty($alertMessage)): ?>
            Swal.fire({
                icon: '<?php echo $alertType; ?>',
                title: '<?php echo ucfirst($alertType); ?>',
                text: '<?php echo addslashes($alertMessage); ?>',
                confirmButtonText: 'Tamam'
            }).then(function() {
                window.location.href = window.location.href; // Sayfayı yeniden yükle
            });
        <?php endif; ?>
    });
    </script>
</body>
</html>
