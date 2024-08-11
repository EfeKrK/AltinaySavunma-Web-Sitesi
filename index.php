<?php
// Veritabanı bağlantısını dahil edin
include 'database.php';

// slider tablosundan son 8 projeyi çek
$sql_slider = "SELECT baslik, özet, resim FROM slider ORDER BY tarih DESC LIMIT 8";
$result_slider = $conn->query($sql_slider);

// Slider verilerini tutmak için dizi oluştur
$slides = [];

if ($result_slider->num_rows > 0) {
    while($row = $result_slider->fetch_assoc()) {
        $slides[] = $row;
    }
} else {
    echo "0 results";
}

// Kartlar tablosundan son 4 kartı çek
$sql_kartlar = "SELECT baslik, özet, resim FROM kartlar ORDER BY tarih DESC LIMIT 10";
$result_kartlar = $conn->query($sql_kartlar);

// Kart verilerini tutmak için dizi oluştur
$cards = [];

if ($result_kartlar->num_rows > 0) {
    while($row = $result_kartlar->fetch_assoc()) {
        $cards[] = $row;
    }
} else {
    echo "0 results";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ana Sayfa</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/scroller.css">
    <link rel="stylesheet" href="css/cards.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/sekmelogosu.png" type="image/x-icon">
    <style>
        .carousel-item {
            transition: transform 0.6s ease-in-out;
        }

        .carousel-item-next,
        .carousel-item-prev {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            transition: transform 0.6s ease-in-out;
        }

        .carousel-item-next {
            transform: translateX(100%);
        }

        .carousel-item-prev {
            transform: translateX(-100%);
        }

        .carousel-item-next.carousel-item-start,
        .carousel-item-prev.carousel-item-end {
            transform: translateX(0);
        }

        .carousel-item-next.carousel-item-end {
            transform: translateX(100%);
        }

        .carousel-item-prev.carousel-item-start {
            transform: translateX(-100%);
        }

        .carousel-control-prev,
        .carousel-control-next {
            filter: invert(1);
        }
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
                    <a class="nav-link active" aria-current="page" href="#">Ana Sayfa</a>
                    <a class="nav-link" href="projeler.php">Projeler</a>
                    <a class="nav-link"  href="Medya.php">Medya</a>
                    <a class="nav-link" href="hakkimizda.php">Hakkımızda</a>
                    <a class="nav-link" href="iletisim.php">İletişim</a>
                </div>
            </div>
        </div>
    </nav>

    

    <!-- Slider -->
    <div class="container-fluid p-0">
        <div id="slider1" class="carousel slide" data-bs-ride="carousel">
            <ol class="carousel-indicators">
                <?php foreach ($slides as $index => $slide): ?>
                    <li data-bs-target="#slider1" data-bs-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>"></li>
                <?php endforeach; ?>
            </ol>
            <div class="carousel-inner">
                <?php foreach ($slides as $index => $slide): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <img src="data:image/jpeg;base64,<?= base64_encode($slide['resim']) ?>" class="d-block w-100" alt="<?= htmlspecialchars($slide['baslik']) ?>">
                        <div class="carousel-caption">
                            <h5><?= htmlspecialchars($slide['baslik']) ?></h5>
                            <p><?= htmlspecialchars($slide['özet']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#slider1" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#slider1" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

<!-- Card Section Normal Masaüstü -->
<div class="container mt-4">
    <div class="card-carousel-container">
        <h3 class="kart-baslik">Medya</h3>
        <div id="cardCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php foreach (array_chunk($cards, 4) as $index => $cardChunk): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <div class="row">
                            <?php foreach ($cardChunk as $card): ?>
                                <div class="col-md-3">
                                    <div class="card">
                                        <img src="data:image/jpeg;base64,<?= base64_encode($card['resim']) ?>" class="card-img-top" alt="<?= htmlspecialchars($card['baslik']) ?>">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= htmlspecialchars($card['baslik']) ?></h5>
                                            <?= htmlspecialchars(mb_substr($card['özet'], 0, 150, 'UTF-8')) ?>...
                                            </div>
                                        <div class="card-footer">
                                            <a href="#" class="btn btn-primary">Detayları Gör</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- Sol ve sağ butonlar -->
        <button class="carousel-control-prev" type="button" data-bs-target="#cardCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#cardCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>


       




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
   

    <br>
    
    <hr style="border: none; border-top: 3px solid #000; margin: 20px 0;">
    <br>
    
    <div class="hero bg-google-map text-white text-center d-flex align-items-center justify-content-center">
        <div class="map-container" style="width: 100%; max-width: 100%; margin: 0 auto;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3018.7243691258063!2d29.566644075696544!3d40.83401753013739!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14cb25001b1f98ab%3A0x2fa8d1292ce7df39!2sAlt%C4%B1nay%20Savunma%20Teknolojileri%20A.%C5%9E.!5e0!3m2!1str!2str!4v1722500156721!5m2!1str!2str" width="100%" height="300px" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
    <br>
    <br>

    <footer class="footer mt-auto py-2">
    <div class="footer-container text-center">
        <span class="text-muted">Altınay Savunma Teknolojileri A.Ş. &copy; 2024. Tüm hakları saklıdır.</span>
    </div>
    </footer>

</body>
</html>
