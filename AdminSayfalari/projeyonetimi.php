<?php
include 'GirisKontrol.php';
include 'database.php'; // Veritabanı bağlantısı

$alertMessage = '';

// Silme işlemi
if (isset($_POST['delete'])) {
    if (!empty($_POST['ids'])) {
        $idsToDelete = $_POST['ids'];
        $ids = implode(',', array_map('intval', $idsToDelete));
        $sql = "DELETE FROM projeler WHERE id IN ($ids)";
        if ($conn->query($sql) === TRUE) {
            $alertMessage = "Seçili projeler başarıyla silindi!";
        } else {
            $alertMessage = "Hata: " . $conn->error;
        }
    }
}

// Projeleri veritabanından al
$sql = "SELECT id, isim, detay, resim, resim2, resim3, tarih, detay2, detay3 FROM projeler";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proje Yönetimi</title>
    <link rel="stylesheet" href="css/AnaSayfa.css">
    <link rel="stylesheet" href="css/projeyonetimi.css"> <!-- Proje yönetimi için ek CSS dosyası -->
    <link rel="shortcut icon" href="../images/admin-panel.png" type="image/x-icon">
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
                <li><a href="projeyonetimi.php" class="active">Proje Yönetimi</a></li>
                <li><a href="MedyaYonetimi.php">Medya Yönetimi</a></li>
                <li><a href="HakkimizdaYonetimi.php">Hakkımızda Yönetimi</a></li>
                <li><a href="IletisimYonetimi.php">İletişim Yönetimi</a></li>
                <li class="cikisyap"><a href="adminlogout.php">Çıkış Yap</a></li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <h1>Proje Yönetimi</h1>
        <form method="POST" action="" id="projectForm">
            <div class="project-list">
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="project-card">
                            <div class="project-slider">
                                <div class="slider-images">
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row['resim']); ?>" alt="Proje Resmi 1">
                                    <?php if ($row['resim2']): ?>
                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($row['resim2']); ?>" alt="Proje Resmi 2">
                                    <?php endif; ?>
                                    <?php if ($row['resim3']): ?>
                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($row['resim3']); ?>" alt="Proje Resmi 3">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="project-details">
                                <h2><?php echo htmlspecialchars($row['isim']); ?></h2>
                                <p><strong>Detay 1:</strong> <?php echo nl2br(htmlspecialchars($row['detay'])); ?></p>
                                <?php if ($row['detay2']): ?>
                                    <p><strong>Detay 2:</strong> <?php echo nl2br(htmlspecialchars($row['detay2'])); ?></p>
                                <?php endif; ?>
                                <?php if ($row['detay3']): ?>
                                    <p><strong>Detay 3:</strong> <?php echo nl2br(htmlspecialchars($row['detay3'])); ?></p>
                                <?php endif; ?>
                                <p><strong>Tarih:</strong> <?php echo htmlspecialchars($row['tarih']); ?></p>
                                <input type="checkbox" name="ids[]" value="<?php echo $row['id']; ?>" class="project-checkbox">
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No projects found.</p>
                <?php endif; ?>
            </div>
            <button type="submit" name="delete" class="delete-button">Sil Seçilenler</button>
            <a href="projeekle.php" class="add-button">Yeni Ekle</a>
        </form>
    </div>

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            // SweetAlert mesajlarını yönetme
            <?php if (!empty($alertMessage)): ?>
                Swal.fire({
                    title: '<?php echo strpos($alertMessage, "Hata") !== false ? "Hata" : "Başarı"; ?>',
                    text: '<?php echo $alertMessage; ?>',
                    icon: '<?php echo strpos($alertMessage, "Hata") !== false ? "error" : "success"; ?>',
                    confirmButtonText: 'Tamam'
                });
            <?php endif; ?>

            // Checkbox seçimini kontrol eden form doğrulama
            document.getElementById('projectForm').addEventListener('submit', function(event) {
                const checkboxes = document.querySelectorAll('input[name="ids[]"]:checked');
                if (checkboxes.length === 0) {
                    Swal.fire({
                        title: 'Uyarı',
                        text: 'Lütfen en az bir proje seçiniz!',
                        icon: 'warning',
                        confirmButtonText: 'Tamam'
                    });
                    event.preventDefault(); // Formun gönderilmesini engelle
                }
            });

            // Kartların sırayla gelmesi için animasyon
            const cards = document.querySelectorAll('.project-card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.classList.add('visible');
                }, index * 200); // Her kart için 200ms gecikme
            });

            // Slider işlevselliği
            const sliders = document.querySelectorAll('.project-slider');
            sliders.forEach(slider => {
                const images = slider.querySelectorAll('.slider-images img');
                let currentIndex = 0;

                const showImage = (index) => {
                    images.forEach((img, i) => {
                        img.style.display = i === index ? 'block' : 'none';
                    });
                };

                showImage(currentIndex);

                slider.addEventListener('click', () => {
                    currentIndex = (currentIndex + 1) % images.length;
                    showImage(currentIndex);
                });
            });

            // Kartlara tıklama olayını ekleyin
            const projectCards = document.querySelectorAll('.project-card');

            projectCards.forEach(card => {
                card.addEventListener('click', function(event) {
                    // Eğer checkbox veya kartın içindeki başka bir element tıklanmadıysa
                    if (!event.target.classList.contains('project-checkbox')) {
                        const checkbox = card.querySelector('.project-checkbox');
                        checkbox.checked = !checkbox.checked; // Checkbox'ı işaretle veya kaldır
                    }
                });
            });
        });
    </script>
</body>
</html>
