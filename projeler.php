<?php
include 'database.php'; // Veritabanı bağlantısını içe aktar

// Veritabanına bağlan
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// Sayfa numarasını al
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 6; // Sayfada gösterilecek proje sayısı
$offset = ($page - 1) * $limit;

// Toplam proje sayısını al
$totalSql = "SELECT COUNT(*) AS total FROM projeler";
$totalResult = $conn->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$totalProjects = $totalRow['total'];
$totalPages = ceil($totalProjects / $limit);

// Projeleri al
$sql = "SELECT * FROM projeler LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

$projects = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeler</title>
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/scroller.css">
    <link rel="stylesheet" href="css/projeler.css"> <!-- Harici CSS dosyası -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/sekmelogosu.png" type="image/x-icon">
    <style>
        
        .project-card {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .project-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .fade-in {
            opacity: 0;
            transform: translateY(-20px);
            transition: opacity 1s ease, transform 1s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination-link {
            margin: 0 5px;
            transition: background-color 0.3s ease;
        }

        .pagination-link:hover {
            background-color: rgba(0, 0, 0, 0.1);
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
                <a class="nav-link active" href="projeler.php">Projeler</a>
                <a class="nav-link"  href="Medya.php">Medya</a>
                <a class="nav-link" href="hakkimizda.php">Hakkımızda</a>
                <a class="nav-link" href="iletisim.php">İletişim</a>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center mb-4 fade-in" id="projects-title">Projeler</h2>
    <div class="row">
        <?php if (empty($projects)): ?>
            <p class="text-center">Henüz proje bulunmuyor.</p>
        <?php else: ?>
            <?php foreach ($projects as $project): ?>
                <div class="col-md-4 mb-4">
                    <div class="project-card">
                        <?php
                        $imageData = base64_encode($project['resim']);
                        $imageSrc = 'data:image/jpeg;base64,' . $imageData;
                        ?>
                        <img src="<?php echo $imageSrc; ?>" alt="Proje Resmi" class="project-image">
                        <div class="project-card-body">
                            <h3 class="project-title"><?php echo htmlspecialchars($project['isim']); ?></h3>
                            <p class="project-date">Tarih: <?php echo htmlspecialchars($project['tarih']); ?></p>
                            <p class="project-detail"><?php echo htmlspecialchars(substr($project['detay'], 0, 200)) . (strlen($project['detay']) > 200 ? '...' : ''); ?></p>
                            <a href="proje_detay.php?id=<?php echo $project['id']; ?>" class="btn btn-primary">Detaya Git</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="pagination-container">
        <?php if ($page > 1): ?>
            <a href="projeler.php?page=<?php echo $page - 1; ?>" class="btn btn-outline-primary pagination-link">Önceki</a>
        <?php endif; ?>

        <?php if ($page < $totalPages): ?>
            <a href="projeler.php?page=<?php echo $page + 1; ?>" class="btn btn-outline-primary pagination-link">Sonraki</a>
        <?php endif; ?>
    </div>
</div>

<footer class="footer mt-auto py-2">
    <div class="footer-container text-center">
        <span class="text-muted">Altınay Savunma Teknolojileri A.Ş. &copy; 2024. Tüm hakları saklıdır.</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const projectCards = document.querySelectorAll('.project-card');
        const title = document.getElementById('projects-title');

        
        title.classList.add('visible');

        projectCards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add('visible');
            }, index * 200); // Her kartı 200ms aralıklarla gösterir
        });
    });
</script>
</body>
</html>

