<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gemail = $_POST['eposta'];

    // Veritabanı bağlantısını kontrol edin
    if ($conn->connect_error) {
        die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
    }

    // Prepared statement kullanarak SQL injection'ı önleyin
    $query = $conn->prepare("SELECT sifre FROM admins WHERE email = ?");
    if ($query === false) {
        die("Hazırlanan ifadede hata: " . $conn->error);
    }
    
    $query->bind_param('s', $gemail);
    $query->execute();
    $query->bind_result($gideceksifre);
    $query->fetch();
    
    if (!empty($gideceksifre)) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'eucar4941@gmail.com';
            $mail->Password = 'icuccfbliqcppucj';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom('eucar4941@gmail.com', 'Sifre Hatirlatma');
            $mail->addAddress($gemail);
            $mail->Subject = 'Sifre Hatirlatma';
            $mail->Body = 'Sifreniz: ' . $gideceksifre;

            $mail->send();
            $_SESSION['message'] = array(
                "type" => "success",
                "text" => "Şifre hatırlatma e-postası gönderildi."
            );
        } catch (Exception $e) {
            $_SESSION['message'] = array(
                "type" => "error",
                "text" => "E-posta gönderilemedi. Hata: " . $mail->ErrorInfo
            );
        }
    } else {
        $_SESSION['message'] = array(
            "type" => "error",
            "text" => "Bu e-posta adresi ile kayıtlı bir kullanıcı bulunamadı."
        );
    }

    $query->close();
    $conn->close();

    // Redirect to login page
    header("Location: SifremiUnuttum.php");
    exit();
}
?>
