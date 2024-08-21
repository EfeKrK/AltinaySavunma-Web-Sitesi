<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hakkımızda</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/hakkimizda.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="shortcut icon" href="images/sekmelogosu.png" type="image/x-icon">
</head>
<body>
    
<!-- Sekme Logosunda problem yarattığı için body içine aldım -->
<?php
include 'database.php';
include 'bootstrap.php';

// Veritabanı sorgusu
$hakkimizdaQuery = "SELECT * FROM hakkimizda";
$hakkimizdaResult = $conn->query($hakkimizdaQuery);

// Hakkımızda bilgilerini dizi olarak al
$hakkimizdaBilgileri = $hakkimizdaResult->fetch_assoc();

// Başlık, açıklama ve resim verilerini değişkenlere ata
$baslik = $hakkimizdaBilgileri['baslik'];
$aciklama = $hakkimizdaBilgileri['aciklama'];
$resimBlob = $hakkimizdaBilgileri['resim']; // Resim verisi

// BLOB verisini base64 formatına çevir
$resimBase64 = base64_encode($resimBlob);
$resimMimeType = 'image/jpeg'; // Resim formatı, örneğin jpeg, png vs.
$resimDataUrl = 'data:' . $resimMimeType . ';base64,' . $resimBase64;
?>



<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="images/Ornek.png" alt="" width="100" height="75">
        </a>
        <a class="navbar-brand header-text" href="index.php">Altınay Savunma Teknolojileri A.Ş.</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-auto me-5">
                <a class="nav-link" aria-current="page" href="index.php">Ana Sayfa</a>
                <a class="nav-link" href="projeler.php">Projeler</a>
                <a class="nav-link"  href="Medya.php">Medya</a>
                <a class="nav-link active" href="hakkimizda.php">Hakkımızda</a>
                <a class="nav-link" href="iletisim.php">İletişim</a>
            </div>
        </div>
    </div>
</nav>


<div class="container mt-4 position-relative">
    <div class="row">
        <div class="col-md-4">
            <img src="<?php echo $resimDataUrl; ?>" alt="Hakkımızda" class="img-fluid hakkimizda-resim">
        </div>
        <div class="col-md-8">
            <h2><?php echo $baslik; ?></h2>
            <p><?php echo $aciklama; ?></p>
        </div>
        
        <div class="social-media-icons">
            <a href="https://www.facebook.com/altinaysavunma" target="_blank" class="fab fa-facebook"></a>
            <a href="https://twitter.com/altinaysavunma" target="_blank" class="fab fa-x-twitter"></a>
            <a href="https://tr.linkedin.com/company/altinaysavunma" target="_blank" class="fab fa-linkedin"></a>
            <a href="https://www.instagram.com/altinaysavunma/" target="_blank" class="fab fa-instagram"></a>
        </div>
    </div>
</div>

<footer class="footer mt-auto py-2">
    <div class="footer-container text-center">
        <span class="text-muted">Altınay Savunma Teknolojileri A.Ş. &copy; 2024. Tüm hakları saklıdır.</span>
    </div>
</footer>

</body>
</html>
