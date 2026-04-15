<?php

$baglan = new mysqli("localhost", "root", "", "sinema");

if($baglan->connect_error){
    die("Bağlantı hatası");
}

?>

<?php
$host = "localhost";
$db   = "sinema";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    die("DB Hata: " . $e->getMessage());
}
?>