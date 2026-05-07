<?php

$hata = "";
$basari = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $isim = trim($_POST["isim"]);
    $mail = trim($_POST["mail"]);
    $telefon = trim($_POST["telefon"]);
    $sifre = trim($_POST["sifre"]);

    /* İSİM KONTROL */
    if(!preg_match("/^[a-zA-ZğüşöçıİĞÜŞÖÇ\s]+$/u", $isim)){

        $hata = "İsim alanında sadece harf kullanabilirsiniz!";

    }

    /* MAİL KONTROL */
    else if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){

        $hata = "Geçerli bir mail adresi giriniz!";

    }

    /* TELEFON KONTROL */
    else if(!preg_match("/^0[0-9]{10}$/", $telefon)){

        $hata = "Telefon numarası 0 ile başlamalı ve 11 haneli olmalı!";

    }

    /* ŞİFRE KONTROL */
    else if(strlen($sifre) < 4){

        $hata = "Şifre en az 4 karakter olmalı!";

    }

    else{

        require "baglan.php";

        /* AYNI MAİL VAR MI */
        $kontrol = $pdo->prepare("
        SELECT * FROM kullanicilar
        WHERE mail = :mail
        ");

        $kontrol->execute([
            'mail' => $mail
        ]);

        if($kontrol->rowCount() > 0){

            $hata = "Bu mail adresi zaten kayıtlı!";

        }else{

            /* KAYIT */
            $sql = "
            INSERT INTO kullanicilar
            (isim, mail, telefon, sifre)
            VALUES
            (:isim, :mail, :telefon, :sifre)
            ";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                'isim' => $isim,
                'mail' => $mail,
                'telefon' => $telefon,
                'sifre' => $sifre
            ]);

            $basari = "Üyelik başarıyla oluşturuldu!";

            header("refresh:2;url=giris.php");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>

<meta charset="UTF-8">

<title>Üye Ol</title>

<script src="https://cdn.tailwindcss.com"></script>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:#0e0e0e;
}

</style>

</head>

<body class="min-h-screen flex items-center justify-center p-5">

<div class="bg-gray-900 w-full max-w-md rounded-3xl shadow-2xl border border-gray-800 p-10">

<!-- LOGO -->

<div class="text-center mb-8">

<h1 class="text-4xl font-bold text-red-500">
CineDavud
</h1>

<p class="text-gray-400 mt-2">
Yeni hesap oluştur
</p>

</div>

<!-- HATA -->

<?php if($hata){ ?>

<div class="bg-red-600 text-white text-center p-3 rounded-xl mb-5">
<?= $hata ?>
</div>

<?php } ?>

<!-- BAŞARI -->

<?php if($basari){ ?>

<div class="bg-green-600 text-white text-center p-3 rounded-xl mb-5">
<?= $basari ?>
</div>

<?php } ?>

<!-- FORM -->

<form method="POST" class="space-y-5">

<!-- İSİM -->

<div>

<label class="text-gray-300 block mb-2">
İsim Soyisim
</label>

<input
type="text"
name="isim"
placeholder="Ad Soyad"
class="w-full p-4 rounded-xl bg-gray-800 border border-gray-700 text-white outline-none focus:border-red-500"
required>

</div>

<!-- MAİL -->

<div>

<label class="text-gray-300 block mb-2">
Mail Adresi
</label>

<input
type="text"
name="mail"
placeholder="ornek@mail.com"
class="w-full p-4 rounded-xl bg-gray-800 border border-gray-700 text-white outline-none focus:border-red-500"
required>

</div>

<!-- TELEFON -->

<div>

<label class="text-gray-300 block mb-2">
Telefon Numarası
</label>

<input
type="text"
name="telefon"
placeholder="05XXXXXXXXX"
maxlength="11"
class="w-full p-4 rounded-xl bg-gray-800 border border-gray-700 text-white outline-none focus:border-red-500"
required>


</div>

<!-- ŞİFRE -->

<div>

<label class="text-gray-300 block mb-2">
Şifre
</label>

<input
type="password"
name="sifre"
placeholder="Şifrenizi oluşturun"
class="w-full p-4 rounded-xl bg-gray-800 border border-gray-700 text-white outline-none focus:border-red-500"
required>

</div>

<!-- BUTON -->

<button
type="submit"
class="w-full bg-red-600 hover:bg-red-700 transition py-4 rounded-xl text-lg font-semibold">

Kayıt Ol

</button>

</form>

<!-- ALT -->

<div class="text-center mt-8 text-gray-400">

Zaten hesabınız var mı?

<a href="giris.php"
class="text-red-500 hover:text-red-400 font-semibold ml-1">
Giriş Yap
</a>

</div>

</div>

</body>
</html>