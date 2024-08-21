<?php
// Veritabanı bağlantısını dahil et
include 'database.php';

// Medya ID'sini almak için URL parametresini kontrol et
$medyaID = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Medya detaylarını almak için veritabanı sorgusu
$sql = "SELECT * FROM kartlar WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $medyaID);
$stmt->execute();
$result = $stmt->get_result();
$medya = $result->fetch_assoc();

// Resim ve detayları veritabanından çek
$resimBlob = $medya['resim'];
$detay = $medya['içerik'];

// BLOB verilerini base64 formatına çevir
$resimBase64 = base64_encode($resimBlob);
$resimMimeType = 'image/jpeg'; // Varsayılan resim formatı
$resimDataUrl = 'data:' . $resimMimeType . ';base64,' . $resimBase64;

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($medya['baslik']); ?> - Medya Detayları</title>
    <link rel="stylesheet" href="css/medya_Detaylar.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/scroller.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/sekmelogosu.png" type="image/x-icon">
</head>
<body>

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
                <a class="nav-link active" href="Medya.php">Medya</a>
                <a class="nav-link" href="hakkimizda.php">Hakkımızda</a>
                <a class="nav-link" href="iletisim.php">İletişim</a>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-4 fade-in">
    <h1><?php echo htmlspecialchars($medya['baslik']); ?></h1>
    
    <div class="row mb-4 fade-in">
        <div class="col-md-6">
            <img src="<?php echo $resimDataUrl; ?>" alt="<?php echo htmlspecialchars($medya['baslik']); ?>" class="img-fluid">
        </div>
    </div>

    <div class="aciklama"><p><?php echo nl2br(htmlspecialchars($detay)); ?></p></div>
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
            }, index * 200);
        });
    });
</script>

</body>
</html>
