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

<?php
include 'database.php';
include 'bootstrap.php';

// Hakkımızda bilgilerini al
$hakkimizdaQuery = "SELECT * FROM hakkimizda";
$hakkimizdaResult = $conn->query($hakkimizdaQuery);
$hakkimizdaBilgileri = $hakkimizdaResult->fetch_assoc();

$baslik = $hakkimizdaBilgileri['baslik'];
$aciklama = $hakkimizdaBilgileri['aciklama'];
$resimBlob = $hakkimizdaBilgileri['resim'];
$resimBase64 = base64_encode($resimBlob);
$resimMimeType = 'image/jpeg';
$resimDataUrl = 'data:' . $resimMimeType . ';base64,' . $resimBase64;

// Yönetim ekibi bilgilerini al
$yonetimQuery = "SELECT * FROM yonetimekibi Where id=1";
$yonetimResult = $conn->query($yonetimQuery);
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
    <!-- Hakkımızda Bölümü -->
    <div class="row mb-5 align-items-center">
        <div class="col-md-4 text-center">
            <img src="<?php echo $resimDataUrl; ?>" alt="Hakkımızda" class="img-fluid hakkimizda-resim">
        </div>
        <div class="col-md-8">
            <h2><?php echo $baslik; ?></h2>
            <p><?php echo $aciklama; ?></p>
        </div>
    </div>

    <!-- Yönetim Ekibi Bölümü -->
    
    <div class="row2 mb-5">
        
        <?php while ($yonetimUye = $yonetimResult->fetch_assoc()): ?>
            <?php
            $uyeIsim = $yonetimUye['isim'];
            $uyeSoyisim = $yonetimUye['soyisim'];
            $uyeAciklama = $yonetimUye['aciklama'];
            $uyeResimBlob = $yonetimUye['resim'];
            $uyeResimBase64 = base64_encode($uyeResimBlob);
            $uyeResimMimeType = 'image/jpeg';
            $uyeResimDataUrl = 'data:' . $uyeResimMimeType . ';base64,' . $uyeResimBase64;
            ?>
            <div class="row align-items-center mb-4">
                <div class="col-md-4 text-center">
                    <img src="<?php echo $uyeResimDataUrl; ?>" alt="<?php echo $uyeIsim . ' ' . $uyeSoyisim; ?>" class="img-fluid yonetim-resim">
                </div>
                <div class="col-md-8">
                    <h3><?php echo 'Kurucumuz - '.$uyeIsim . ' ' . $uyeSoyisim; ?></h3>
                    <p><?php echo $uyeAciklama; ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<footer class="footer mt-auto py-2">
    <div class="footer-container text-center">
        <span class="text-muted">Altınay Savunma Teknolojileri A.Ş. &copy; 2024. Tüm hakları saklıdır.</span>
    </div>
</footer>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const container = document.querySelector(".container.mt-4");
    const rows = document.querySelectorAll(".row");

    // Ensure the container is initially hidden
    container.style.opacity = 0;
    container.style.transform = "translateY(20px)";
    container.style.transition = "opacity 1s ease-out, transform 1s ease-out";
    
    // Apply a delay to the fade-in effect for the container
    setTimeout(() => {
        container.style.opacity = 1;
        container.style.transform = "translateY(0)";
    }, 100); // 100ms delay before starting the fade-in effect

    // Animate the .row elements
    rows.forEach((row, index) => {
        row.style.opacity = 0; // Initially hidden
        row.style.transform = "translateY(20px)"; // Initially offset
        row.style.transition = "opacity 1s ease-out, transform 1s ease-out"; // Transition for fade-in and slide-up

        // Apply a delay to each .row animation
        setTimeout(() => {
            row.style.opacity = 1;
            row.style.transform = "translateY(0)";
        }, 200 * (index + 1)); // Stagger animations by 200ms each
    });
});
</script>

</body>
</html>
