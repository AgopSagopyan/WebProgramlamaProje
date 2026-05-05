<?php
session_start();
require "baglan.php";

$hata = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $mail = trim($_POST["mail"]);
    $sifre = trim($_POST["sifre"]);

    if(empty($mail) || empty($sifre)){
        $hata = "Boş bırakmayın!";
    } else {

        // KULLANICIYI BUL
        $stmt = $pdo->prepare("SELECT * FROM kullanicilar WHERE mail = :mail");
        $stmt->execute(['mail' => $mail]);
        $kullanici = $stmt->fetch();

        if ($kullanici && $kullanici['sifre'] == $sifre) {

            // SESSION
            $_SESSION['kullanici_id'] = $kullanici['id'];
            $_SESSION['kullanici_isim'] = $kullanici['isim'];
            $_SESSION['kullanici_email'] = $kullanici['mail'];

            // COOKIE (7 GÜN)
            setcookie("kullanici_id", $kullanici['id'], time()+604800, "/");
            setcookie("kullanici_isim", $kullanici['isim'], time()+604800, "/");
            setcookie("kullanici_email", $kullanici['mail'], time()+604800, "/");

            header("Location: anasayfa.php");
            exit();

        } else {
            $hata = "Mail veya şifre yanlış!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Giriş Yap</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-black flex items-center justify-center h-screen">

<div class="bg-gray-900 p-10 rounded-2xl w-full max-w-md text-white shadow-2xl">

<h1 class="text-3xl font-bold text-center mb-6">Giriş Yap</h1>

<?php if($hata): ?>
<div class="bg-red-600 p-3 rounded mb-4 text-center">
<?= $hata ?>
</div>
<?php endif; ?>

<form method="POST">

<input name="mail"
type="email"
placeholder="Mail adresi"
class="w-full p-3 mb-4 rounded text-black"
required>

<input name="sifre"
type="password"
placeholder="Şifre"
class="w-full p-3 mb-6 rounded text-black"
required>

<button class="w-full bg-blue-600 py-3 rounded-lg font-semibold hover:bg-blue-700">
Giriş Yap
</button>

</form>

</div>

</body>
</html>