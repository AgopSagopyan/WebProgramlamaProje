<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require "baglanti.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $isim = $_POST["isim"] ?? "";
    $mail = $_POST["mail"] ?? "";
    $telefon = $_POST["telefon"] ?? "";
    $sifre = $_POST["sifre"] ?? "";

    if (!$isim || !$mail || !$telefon || !$sifre) {
        echo "bos";
        exit;
    }

    $sifreHash = password_hash($sifre, PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO kullanicilar (isim, mail, telefon, sifre)
                VALUES (?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$isim, $mail, $telefon, $sifreHash]);

        echo "success";
    } catch (PDOException $e) {
        echo "error: " . $e->getMessage();
    }
}