<?php
include 'database.php';

$response = array("status" => "error", "message" => "Bir hata oluştu.");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Veritabanına bağlan
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Bağlantıyı kontrol et
    if ($conn->connect_error) {
        $response["message"] = "Bağlantı hatası: " . $conn->connect_error;
    } else {
        // Form verilerini al
        $isim = $_POST['isim'];
        $soyisim = $_POST['soyisim'];
        $sirket = $_POST['sirket'];
        $pozisyon = $_POST['pozisyon'];
        $telefon = $_POST['telefon'];
        $eposta = $_POST['eposta'];
        $mesaj = $_POST['mesaj'];

        // Veritabanına ekleme sorgusu
        $sql = "INSERT INTO iletisim (isim, soyisim, sirket, pozisyon, telefon, eposta, mesaj)
                VALUES ('$isim', '$soyisim', '$sirket', '$pozisyon', '$telefon', '$eposta', '$mesaj')";

        if ($conn->query($sql) === TRUE) {
            $response["status"] = "success";
            $response["message"] = "Mesajınız başarıyla gönderildi!";
        } else {
            $response["message"] = "Hata: " . $sql . "<br>" . $conn->error;
        }

        // Bağlantıyı kapat
        $conn->close();
    }

    // Yanıtı JSON formatında döndür
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İletişim</title>
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/iletisim.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/sekmelogosu.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .contact-info {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .contact-info .icon {
            font-size: 24px;
            margin-right: 10px;
        }

        .contact-info p {
            margin: 0;
            font-size: 1rem;
        }

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
                <a class="nav-link active" href="iletisim.php">İletişim</a>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-3">
    <div class="row">
        <div class="col-md-4">
            <h2>Bize Ulaşın</h2>
            <br>
            <div class="contact-info">
                <div class="icon">🏢</div>
                <p>Hacı Akif, Makine Organize Sanayi Bölgesi,<br>41455 Dilovası/Kocaeli</p>
            </div>
            <div class="contact-info">
                <div class="icon">📞</div>
                <p><strong>Telefon:</strong> +90 216 504 00 50</p>
            </div>
            <div class="contact-info">
                <div class="icon">✉️</div>
                <p><strong>E-posta:</strong> savunma@altinay.com</p>
            </div>
        </div>
        <div class="col-md-8">
            <form action="" method="post">
                <div class="row mb-3 fade-in">
                    <div class="col">
                        <label for="isim" class="form-label">İsim*</label>
                        <input type="text" class="form-control" id="isim" name="isim" required>
                    </div>
                    <div class="col">
                        <label for="soyisim" class="form-label">Soyisim*</label>
                        <input type="text" class="form-control" id="soyisim" name="soyisim" required>
                    </div>
                </div>
                <div class="row mb-3 fade-in">
                    <div class="col">
                        <label for="sirket" class="form-label">Şirketiniz*</label>
                        <input type="text" class="form-control" id="sirket" name="sirket" required>
                    </div>
                    <div class="col">
                        <label for="pozisyon" class="form-label">Pozisyonunuz*</label>
                        <input type="text" class="form-control" id="pozisyon" name="pozisyon" required>
                    </div>
                </div>
                <div class="row mb-3 fade-in">
                    <div class="col">
                        <label for="telefon" class="form-label">Telefon*</label>
                        <input type="text" class="form-control" id="telefon" name="telefon" required>
                    </div>
                    <div class="col">
                        <label for="eposta" class="form-label">E-posta*</label>
                        <input type="email" class="form-control" id="eposta" name="eposta" required>
                    </div>
                </div>
                <div class="mb-3 fade-in">
                    <label for="mesaj" class="form-label">Mesaj*</label>
                    <textarea class="form-control" id="mesaj" name="mesaj" rows="4" required></textarea>
                </div>
                <div class="mb-3 checkbox-group fade-in">
                    <input type="checkbox" id="kvkk" name="kvkk" required>
                    <label for="kvkk">Kişisel Verilerin korunmasına ilişkin bilgilendirmeyi okudum / anladım</label>
                </div>
                <div class="mb-3 checkbox-group fade-in">
                    <input type="checkbox" id="izin" name="izin">
                    <label for="izin">İletişim bilgilerime kampanya, promosyon ve reklam içerikli ticari elektronik ileti gönderilmesine ve kişisel verilerimin bu amaçla işlenmesine açık rıza veriyorum.</label>
                </div>
                <button type="submit" class="btn btn-primary">GÖNDER</button>
            </form>
        </div>
    </div>
</div>

<footer class="footer mt-auto py-2">
    <div class="footer-container text-center">
        <span class="text-muted">Altınay Savunma Teknolojileri A.Ş. &copy; 2024. Tüm hakları saklıdır.</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const formElements = document.querySelectorAll('.fade-in');

    formElements.forEach((element, index) => {
        setTimeout(() => {
            element.classList.add('visible');
        }, index * 200); // Her bir elementi 200ms arayla göster
    });

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Formun varsayılan gönderimini engelle

        const formData = new FormData(form);

        fetch('', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                Swal.fire({
                    icon: 'success',
                    title: 'Başarılı',
                    text: data.message,
                }).then(() => {
                    form.reset(); // Formu sıfırla
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Hata',
                    text: data.message,
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Hata',
                text: 'Bir hata oluştu. Lütfen tekrar deneyin.',
            });
        });
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
