<?php
session_start();
require "baglan.php";

$hata = "";

/* FORM GÖNDERİLDİ */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $mail = trim($_POST["mail"]);
    $sifre = trim($_POST["sifre"]);

    /* BOŞ KONTROL */
    if(empty($mail) || empty($sifre)){

        $hata = "Tüm alanları doldurun!";

    }

    /* MAİL FORMAT */
    else if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){

        $hata = "Geçerli bir mail adresi giriniz!";

    }

    else{

        /* KULLANICIYI BUL */
        $stmt = $pdo->prepare("
        SELECT * FROM kullanicilar
        WHERE mail = :mail
        ");

        $stmt->execute([
            'mail' => $mail
        ]);

        $kullanici = $stmt->fetch();

        /* KULLANICI VAR MI */
        if(!$kullanici){

            $hata = "Böyle bir mail adresi bulunamadı!";

        }

        /* ŞİFRE KONTROL */
        else if($kullanici['sifre'] != $sifre){

            $hata = "Şifre yanlış!";

        }

        else{

            /* SESSION */
            $_SESSION['kullanici_id'] = $kullanici['id'];
            $_SESSION['kullanici_isim'] = $kullanici['isim'];
            $_SESSION['kullanici_email'] = $kullanici['mail'];

            /* COOKIE */
            setcookie(
                "kullanici_id",
                $kullanici['id'],
                time()+604800,
                "/"
            );

            setcookie(
                "kullanici_isim",
                $kullanici['isim'],
                time()+604800,
                "/"
            );

            setcookie(
                "kullanici_email",
                $kullanici['mail'],
                time()+604800,
                "/"
            );

            header("Location: anasayfa.php");
            exit();
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

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
font-family:'Poppins',sans-serif;
}

body{
background:#0e0e0e;
}

</style>

</head>

<body class="min-h-screen flex items-center justify-center p-5">

<div class="bg-gray-900 w-full max-w-md rounded-3xl p-10 shadow-2xl border border-gray-800">

<!-- LOGO -->

<div class="text-center mb-8">

<h1 class="text-4xl font-bold text-red-500">
CineDavud
</h1>

<p class="text-gray-400 mt-2">
Hesabınıza giriş yapın
</p>

</div>

<!-- HATA -->

<?php if($hata){ ?>

<div class="bg-red-600 text-white text-center p-3 rounded-xl mb-5">
<?= $hata ?>
</div>

<?php } ?>

<!-- FORM -->

<form method="POST" class="space-y-5">

<div>

<label class="text-gray-300 block mb-2">
Mail Adresi
</label>

<input
name="mail"
type="text"
placeholder="ornek@mail.com"
class="w-full p-4 rounded-xl bg-gray-800 text-white outline-none border border-gray-700 focus:border-blue-500"
required>

</div>

<div>

<label class="text-gray-300 block mb-2">
Şifre
</label>

<input
name="sifre"
type="password"
placeholder="Şifrenizi girin"
class="w-full p-4 rounded-xl bg-gray-800 text-white outline-none border border-gray-700 focus:border-blue-500"
required>

</div>

<button
class="w-full bg-red-600 hover:bg-red-700 transition py-4 rounded-xl font-semibold text-lg">
Giriş Yap
</button>

</form>

<!-- ALT -->

<div class="text-center mt-8 text-gray-400">

Hala üye değil misiniz?

<a href="uyeol.php"
class="text-red-500 hover:text-red-400 font-semibold ml-1">
Üye Ol
</a>

</div>

</div>

</body>
</html>