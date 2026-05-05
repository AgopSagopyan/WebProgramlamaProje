<?php
include("baglan.php");

$kullanici = "admin";
$sifre = password_hash("1234", PASSWORD_DEFAULT);

$stmt = $baglan->prepare("INSERT INTO adminler (kullanici, sifre) VALUES (?, ?)");
$stmt->bind_param("ss", $kullanici, $sifre);
$stmt->execute();

echo "Admin oluşturuldu";
?>