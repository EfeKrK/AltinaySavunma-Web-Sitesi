<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "altınaysav";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Bağlantı başarısız: " . $conn->connect_error);
}   

?>