<?php
// Veritabanı bağlantısını sağlayan dosyayı içe aktar
include 'database.php';

session_start();

/*
// Kullanıcı giriş yapmış mı kontrol et
if (!isset($_SESSION['adminid'])) {
    header("Location: ../adminlogin.php"); // Giriş sayfasına yönlendir
    exit();
}
*/

$alertMessage = ''; // Kullanıcıya gösterilecek mesaj için değişken

// Eğer form gönderildiyse
if(isset($_POST['ekle'])) {
    // Formdan gelen verileri al
    $isim = $_POST['isim']; 
    $detay = $_POST['detay'];
    $detay2 = $_POST['detay2']; 
    $detay3 = $_POST['detay3']; 
    $tarih = $_POST['tarih']; 

    // Resim dosyalarını işleme ve kontrol etme
    $resimIcerik1 = !empty($_FILES['resim']['tmp_name']) && file_exists($_FILES['resim']['tmp_name']) ? file_get_contents($_FILES['resim']['tmp_name']) : null;
    $resimIcerik2 = !empty($_FILES['resim2']['tmp_name']) && file_exists($_FILES['resim2']['tmp_name']) ? file_get_contents($_FILES['resim2']['tmp_name']) : null;
    $resimIcerik3 = !empty($_FILES['resim3']['tmp_name']) && file_exists($_FILES['resim3']['tmp_name']) ? file_get_contents($_FILES['resim3']['tmp_name']) : null;

    // SQL sorgusunu hazırla
    $sorgu = "INSERT INTO projeler (isim, detay, resim, tarih, resim2, resim3, detay2, detay3) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Sorguyu hazırla ve bağlantıyı kullan
    $stmt = mysqli_prepare($conn, $sorgu); // Sorguyu hazırla
    if ($stmt) {
        // Değişkenleri bağla
        mysqli_stmt_bind_param($stmt, "ssssssss", $isim, $detay, $resimIcerik1, $tarih, $resimIcerik2, $resimIcerik3, $detay2, $detay3);

        // Sorguyu çalıştır
        if(mysqli_stmt_execute($stmt)) {
            $alertMessage = "Yeni proje başarıyla eklendi."; // Başarı mesajı
        } else {
            $alertMessage = "Proje eklenirken bir hata oluştu: " . mysqli_error($conn); // Hata mesajı
        }

        // İşlem sonrasında bağlantıyı kapat
        mysqli_stmt_close($stmt); // Sorgu bağlantısını kapat
    } else {
        $alertMessage = "Sorgu hazırlanırken bir hata oluştu: " . mysqli_error($conn); // Hata mesajı
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/AnaSayfa.css">
    <link rel="stylesheet" href="css/projeekle.css">
    <link rel="shortcut icon" href="../images/admin-panel.png" type="image/x-icon">
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
                <li><a href="slideryonetimi.php">Slider Yönetimi</a></li>
                <li><a href="projeyonetimi.php" class="active">Proje Yönetimi</a></li>
                <li><a href="MedyaYonetimi.php">Medya Yönetimi</a></li>
                <li><a href="HakkimizdaYonetimi.php">Hakkımızda Yönetimi</a></li>
                <li><a href="IletisimYonetimi.php">İletişim Yönetimi</a></li>
                <li class="cikisyap"><a href="adminlogout.php">Çıkış Yap</a></li>
            </ul>
        </div>
    </div>

    <div class="content">
        <h2 class="header">Proje Ekle</h2>
        <form id="projectForm" method="POST" action="" enctype="multipart/form-data">
            <label for="isim">Proje ismi:</label>
            <input type="text" id="isim" name="isim" required><br>

            <label for="detay">Detay:</label>
            <textarea id="detay" name="detay" required></textarea><br>

            <label for="detay2">Detay2:</label>
            <textarea id="detay2" name="detay2"></textarea><br>

            <label for="detay3">Detay3:</label>
            <textarea id="detay3" name="detay3"></textarea><br>

            <label for="tarih">Tarih:</label>
            <input type="date" id="tarih" name="tarih" required><br><br>

            <label for="resim">Resim:</label>
            <input type="file" id="resim" name="resim" accept="image/*" required><br>
            
            <label for="resim2">Resim2:</label>
            <input type="file" id="resim2" name="resim2" accept="image/*"><br>

            <label for="resim3">Resim3:</label>
            <input type="file" id="resim3" name="resim3" accept="image/*"><br>

            <input type="submit" name="ekle" value="Proje Ekle">
        </form>
    </div>

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // PHP'den gelen uyarı mesajını kontrol et ve göster
            <?php if (!empty($alertMessage)): ?>
                Swal.fire({
                    title: '<?php echo strpos($alertMessage, "hata") !== false ? "Hata" : "Başarı"; ?>',
                    text: '<?php echo $alertMessage; ?>',
                    icon: '<?php echo strpos($alertMessage, "hata") !== false ? "error" : "success"; ?>',
                    confirmButtonText: 'Tamam'
                });
            <?php endif; ?>

            // Form gönderimi öncesi doğrulama
            document.getElementById('projectForm').addEventListener('submit', function(event) {
                var isim = document.getElementById('isim').value;
                var resim = document.getElementById('resim').value;

                if (isim.trim() === '' || resim.trim() === '') {
                    Swal.fire({
                        title: 'Uyarı',
                        text: 'Lütfen proje ismi ve en az bir resim ekleyin!',
                        icon: 'warning',
                        confirmButtonText: 'Tamam'
                    });
                    event.preventDefault(); // Formun gönderilmesini engelle
                }
            });
        });
    </script>
</body>
</html>
