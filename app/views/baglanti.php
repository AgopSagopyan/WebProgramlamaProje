<?php
$host = "localhost";
$db   = "uye_sistemi";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    die("DB Hata: " . $e->getMessage());
}
?>