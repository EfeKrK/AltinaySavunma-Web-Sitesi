<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/AnaSayfa.css">
    <link rel="stylesheet" href="css/AnaSayfa1.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo-container">
            <img src="../images/adminpanellogo.png" alt="Admin Logo" class="logo">
        </div>
        <h2>Admin Paneli</h2>
        <div class="menu">
            <ul>
                <li><a href="AnaSayfa.php" class="active">Ana Sayfa</a></li>
                <li><a href="slideryonetimi.php">Slider Yönetimi</a></li>
                <li><a href="projeyonetimi.php">Proje Yönetimi</a></li>
                <li><a href="MedyaYonetimi.php">Medya Yönetimi</a></li>
                <li><a href="HakkimizdaYonetimi.php">Hakkımızda Yönetimi</a></li>
                <li><a href="IletisimYonetimi.php">İletişim Yönetimi</a></li>
                <li class="cikisyap"><a href="adminlogout.php">Çıkış Yap</a></li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="logoo">
            <img src="../images/logo-tur.png" alt="Logo" class="logo-image">
        </div>
        <div class="welcome-message">
            <h1>Altınay Savunma Teknolojileri A.Ş. Web Sayfası Paneline Hoşgeldiniz</h1>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Logo ve mesajın başlangıç pozisyonlarını belirleyin
            const logo = document.querySelector(".logo-image");
            const welcomeMessage = document.querySelector(".welcome-message h1");
            
            // Logo animasyonu
            logo.style.opacity = 0;
            logo.style.transform = 'translateY(-50px)';
            logo.style.transition = 'opacity 1s ease, transform 1s ease';

            // Hoşgeldiniz mesajı animasyonu
            welcomeMessage.style.opacity = 0;
            welcomeMessage.style.transform = 'translateY(20px)';
            welcomeMessage.style.transition = 'opacity 1s ease, transform 1s ease';

            // Geçiş efektleri için zamanlayıcılar
            setTimeout(() => {
                logo.style.opacity = 1;
                logo.style.transform = 'translateY(0)';
            }, 200);

            setTimeout(() => {
                welcomeMessage.style.opacity = 1;
                welcomeMessage.style.transform = 'translateY(0)';
            }, 500);
        });
    </script>
</body>
</html>
