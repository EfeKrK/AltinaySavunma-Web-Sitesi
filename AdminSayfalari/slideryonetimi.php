<?php
include 'database.php'; // Include the database connection

// Handle delete request
$alertMessage = '';
if (isset($_POST['delete'])) {
    if (!empty($_POST['ids'])) {
        $idsToDelete = $_POST['ids'];
        $ids = implode(',', array_map('intval', $idsToDelete));
        $sql = "DELETE FROM slider WHERE id IN ($ids)";
        if ($conn->query($sql) === TRUE) {
            $alertMessage = "Seçili olan sliderlar başarıyla silindi!";
        } else {
            $alertMessage = "Hata: " . $conn->error;
        }
    }
}

// Fetch sliders
$sql = "SELECT id, baslik, özet, icerik, resim, tarih FROM slider";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slider Yönetimi</title>
    <link rel="stylesheet" href="css/AnaSayfa.css">
    <link rel="stylesheet" href="css/slideryonetimi.css">
    <link rel="shortcut icon" src="../images/admin-panel.png" type="image/x-icon">
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        /* Animation for sliders */
        .slider-card {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
            transition-delay: 0s; /* Default delay */
        }

        .slider-card.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
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

    <div class="main-content">
        <h1>Slider Yönetimi</h1>
        <form method="POST" action="" id="sliderForm">
            <div class="slider-list">
                <?php if ($result->num_rows > 0): ?>
                    <?php $index = 0; ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="slider-card" style="transition-delay: <?php echo $index * 0.2; ?>s;">
                            <div class="slider-header">
                                <h2><?php echo htmlspecialchars($row['baslik']); ?></h2>
                            </div>
                            <div class="slider-body">
                                <?php if ($row['resim']): ?>
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row['resim']); ?>" alt="Slider Image" class="slider-image">
                                <?php endif; ?>
                                
                                <p><strong>Özet:</strong> <?php echo htmlspecialchars($row['özet']); ?></p>
                                <p><strong>İçerik:</strong> <?php echo nl2br(htmlspecialchars($row['icerik'])); ?></p>
                                <p><strong>Tarih:</strong> <?php echo htmlspecialchars($row['tarih']); ?></p>
                                <input type="checkbox" name="ids[]" value="<?php echo $row['id']; ?>">
                            </div>
                        </div>
                        <?php $index++; ?>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No sliders found.</p>
                <?php endif; ?>
            </div>
            <button type="submit" name="delete" class="delete-button">Sil Seçilenler</button>
        </form>
    </div>

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            // Handle SweetAlert messages
            <?php if (!empty($alertMessage)): ?>
                Swal.fire({
                    title: '<?php echo strpos($alertMessage, "Hata") !== false ? "Hata" : "Başarı"; ?>',
                    text: '<?php echo $alertMessage; ?>',
                    icon: '<?php echo strpos($alertMessage, "Hata") !== false ? "error" : "success"; ?>',
                    confirmButtonText: 'Tamam'
                });
            <?php endif; ?>

            // Form validation for checkbox selection
            document.getElementById('sliderForm').addEventListener('submit', function(event) {
                const checkboxes = document.querySelectorAll('input[name="ids[]"]:checked');
                if (checkboxes.length === 0) {
                    Swal.fire({
                        title: 'Uyarı',
                        text: 'Lütfen en az bir slider seçiniz!',
                        icon: 'warning',
                        confirmButtonText: 'Tamam'
                    });
                    event.preventDefault(); // Prevent the form from submitting
                }
            });

            // Animation for slider cards
            const sliders = document.querySelectorAll('.slider-card');
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            const observerCallback = (entries, observer) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            };

            const observer = new IntersectionObserver(observerCallback, observerOptions);
            sliders.forEach(slider => observer.observe(slider));
        });
    </script>
</body>
</html>

