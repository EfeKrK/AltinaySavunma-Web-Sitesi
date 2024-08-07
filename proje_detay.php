<?php
include 'database.php';

// Proje ID'sini almak için URL parametresini kontrol et
$projeID = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Proje detaylarını almak için veritabanı sorgusu
$sql = "SELECT * FROM projeler WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $projeID);
$stmt->execute();
$result = $stmt->get_result();
$proje = $result->fetch_assoc();

// Resim ve detayları veritabanından çek
$resimBlob = $proje['resim'];
$resim2Blob = isset($proje['resim2']) ? $proje['resim2'] : null;
$resim3Blob = isset($proje['resim3']) ? $proje['resim3'] : null;
$detay1 = $proje['detay'];
$detay2 = isset($proje['detay2']) ? $proje['detay2'] : null;
$detay3 = isset($proje['detay3']) ? $proje['detay3'] : null;

// BLOB verilerini base64 formatına çevir
$resimBase64 = base64_encode($resimBlob);
$resim2Base64 = $resim2Blob ? base64_encode($resim2Blob) : null;
$resim3Base64 = $resim3Blob ? base64_encode($resim3Blob) : null;

$resimMimeType = 'image/jpeg'; // Varsayılan resim formatı
$resimDataUrl1 = 'data:' . $resimMimeType . ';base64,' . $resimBase64;
$resimDataUrl2 = $resim2Base64 ? 'data:' . $resimMimeType . ';base64,' . $resim2Base64 : null;
$resimDataUrl3 = $resim3Base64 ? 'data:' . $resimMimeType . ';base64,' . $resim3Base64 : null;

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proje Detayları</title>
    <link rel="stylesheet" href="css/proje_detay.css">
    <link rel="stylesheet" href="css/scroller.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/sekmelogosu.jpg" type="image/x-icon">
    <style>
        /* Sayfa yüklenirken animasyon */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="images/Ornek.png" alt="" width="100" height="75">
        </a>
        <a class="navbar-brand header-text" href="#">Altınay Savunma Teknolojileri A.Ş.</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-auto me-5">
                <a class="nav-link" aria-current="page" href="index.php">Ana Sayfa</a>
                <a class="nav-link" href="projeler.php">Projeler</a>
                <a class="nav-link" href="hakkimizda.php">Hakkımızda</a>
                <a class="nav-link" href="iletisim.php">İletişim</a>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-4 fade-in">
    <h1><?php echo htmlspecialchars($proje['isim']); ?></h1>
    
    <div class="row mb-4 fade-in">
        <div class="col-md-6">
            <img src="<?php echo $resimDataUrl1; ?>" alt="Proje Resmi 1" class="img-fluid">
        </div>
        <div class="col-md-6">
            <p><?php echo htmlspecialchars($detay1); ?></p>
        </div>
    </div>
    
    <?php if ($detay2 && $resimDataUrl2): ?>
        <hr class="detay-araları fade-in">
        <div class="row mb-4 fade-in">
            

            <div class="col-md-6">
                <img src="<?php echo $resimDataUrl2; ?>" alt="Proje Resmi 2" class="img-fluid">
            </div>

            <div class="col-md-6">
                <p><?php echo htmlspecialchars($detay2); ?></p>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($detay3 && $resimDataUrl3): ?>
        <hr class="detay-araları fade-in">
        <div class="row mb-4 fade-in">
            <div class="col-md-6">
                <img src="<?php echo $resimDataUrl3; ?>" alt="Proje Resmi 3" class="img-fluid">
            </div>
            <div class="col-md-6">
                <p><?php echo htmlspecialchars($detay3); ?></p>
            </div>
        </div>
    <?php endif; ?>
</div>

<footer class="footer mt-auto py-2">
    <div class="footer-container text-center">
        <span class="text-muted">Altınay Savunma Teknolojileri A.Ş. &copy; 2024. Tüm hakları saklıdır.</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const elements = document.querySelectorAll('.fade-in');
        elements.forEach((el, index) => {
            setTimeout(() => {
                el.classList.add('visible');
            }, index * 300); // 300 ms aralıklarla animasyonu başlat
        });
    });
</script>

</body>
</html>

