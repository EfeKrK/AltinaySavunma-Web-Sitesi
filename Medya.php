<?php
include 'database.php'; // Veritabanı bağlantısını ekle

// Kartları çek
$sql = "SELECT id, baslik, özet, resim, tarih FROM kartlar";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medya</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/scroller.css">
    <link rel="stylesheet" href="css/Medya.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/sekmelogosu.png" type="image/x-icon">
    <style>
       
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="images/Ornek.png" alt="" width="100" height="75">
            </a>
            <a class="navbar-brand header-text" href="#">Altınay Savunma Teknolojileri A.Ş.</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto me-5">
                    <a class="nav-link" href="index.php">Ana Sayfa</a>
                    <a class="nav-link" href="projeler.php">Projeler</a>
                    <a class="nav-link active" aria-current="page" href="Medya.php">Medya</a>
                    <a class="nav-link" href="hakkimizda.php">Hakkımızda</a>
                    <a class="nav-link" href="iletisim.php">İletişim</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="container mt-5">
        <?php
        if ($result->num_rows > 0) {
            $delay = 0; // Başlangıçta animasyon gecikmesi
            while($row = $result->fetch_assoc()) {
                echo '<div class="card-container" style="transition-delay: ' . $delay . 's;">';
                echo '<img src="data:image/jpeg;base64,'.base64_encode($row['resim']).'" class="card-image" alt="Resim">';
                echo '<div class="card-content">';
                echo '<h5>'.$row['baslik'].'</h5>';
                echo '<span class="date">'.date('d-m-Y', strtotime($row['tarih'])).'</span>'; // Tarih formatını gün/ay/yıl olarak gösterdik
                echo '<p>'.$row['özet'].'</p>';
                echo '<a href="medya_detaylar.php?id='.$row['id'].'" class="btn btn-primary">Devamını Oku</a>'; // Buton olarak değiştirildi
                echo '</div>';
                echo '</div>';
                $delay += 0; // Her kart için animasyon gecikmesini artır
            }
        } else {
            echo 'Kayıt bulunamadı.';
        }
        $conn->close();
        ?>
    </main>

    <footer class="footer mt-auto py-2">
        <div class="footer-container text-center">
            <span class="text-muted">Altınay Savunma Teknolojileri A.Ş. &copy; 2024. Tüm hakları saklıdır.</span>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card-container');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.classList.add('show');
                }, index * 300); // Her kartın sırasıyla görünmesini sağlamak için gecikme
            });
        });
    </script>
</body>
</html>
