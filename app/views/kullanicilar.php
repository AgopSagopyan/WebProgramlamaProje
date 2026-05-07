<?php
require "baglan.php";

/* KULLANICI EKLE */
if(isset($_POST["ekle"])){

    $isim = $_POST["isim"];
    $mail = $_POST["mail"];
    $telefon = $_POST["telefon"];
    $sifre = $_POST["sifre"];

    $sql = "INSERT INTO kullanicilar
    (isim, mail, telefon, sifre)
    VALUES
    (:isim, :mail, :telefon, :sifre)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        "isim" => $isim,
        "mail" => $mail,
        "telefon" => $telefon,
        "sifre" => $sifre
    ]);
}

/* GÜNCELLE */
if(isset($_POST["guncelle"])){

    $id = $_POST["id"];
    $isim = $_POST["isim"];
    $mail = $_POST["mail"];
    $telefon = $_POST["telefon"];
    $sifre = $_POST["sifre"];

    $sql = "UPDATE kullanicilar SET
    isim=:isim,
    mail=:mail,
    telefon=:telefon,
    sifre=:sifre
    WHERE id=:id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        "isim" => $isim,
        "mail" => $mail,
        "telefon" => $telefon,
        "sifre" => $sifre,
        "id" => $id
    ]);
}

/* SİL */
if(isset($_GET["sil_id"])){

    $sil_id = $_GET["sil_id"];

    $sql = "DELETE FROM kullanicilar WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        "id" => $sil_id
    ]);

    header("Location: kullanicilar.php");
    exit;
}

/* DÜZENLENE */
$duzenle = null;

if(isset($_GET["duzenle_id"])){

    $id = $_GET["duzenle_id"];

    $stmt = $pdo->prepare("SELECT * FROM kullanicilar WHERE id=:id");

    $stmt->execute([
        "id" => $id
    ]);

    $duzenle = $stmt->fetch();
}

/* TÜM KULLANICILAR */
$kullanicilar = $pdo
->query("SELECT * FROM kullanicilar ORDER BY id DESC")
->fetchAll();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Kullanıcılar</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-black min-h-screen flex">

<!-- SOL MENU -->
<div class="w-64 bg-gray-900 p-6 flex flex-col">

<h2 class="text-white text-2xl font-bold mb-8">
Admin Panel
</h2>

<nav class="space-y-4">

<a href="kullanicilar.php"
class="block text-white bg-gray-700 p-2 rounded">
Kullanıcılar
</a>

<a href="admindeneme.php"
class="block text-gray-300 hover:bg-gray-700 p-2 rounded">
Filmler
</a>

<a href="biletadmin.php"
class="block text-gray-300 hover:bg-gray-700 p-2 rounded">
Rezervasyonlar
</a>

<a href="sikayetler.php"
class="block text-gray-300 hover:bg-gray-700 p-2 rounded">
Şikayetler
</a>

<a href="admin.php"
class="block text-gray-300 hover:bg-gray-700 p-2 rounded">
İstatistik
</a>

</nav>

<div class="mt-auto">

<a href="anasayfa.php"
class="block text-red-400 hover:text-red-300 p-2 rounded mt-8">
Çıkış Yap
</a>

</div>

</div>

<!-- SAĞ -->
<div class="flex-1 p-10 text-white">

<div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

<!-- FORM -->
<div class="bg-gray-900 rounded-2xl p-6 shadow-2xl">

<h2 class="text-2xl font-bold mb-6">

<?php if($duzenle){ ?>
Kullanıcı Güncelle
<?php } else { ?>
Yeni Üye Ekle
<?php } ?>

</h2>

<form method="POST" class="space-y-4">

<?php if($duzenle){ ?>

<input type="hidden"
name="id"
value="<?= $duzenle["id"] ?>">

<?php } ?>

<input type="text"
name="isim"
placeholder="İsim Soyisim"
value="<?= $duzenle["isim"] ?? '' ?>"
class="w-full p-3 rounded-lg bg-gray-800 outline-none"
required>

<input type="email"
name="mail"
placeholder="Mail"
value="<?= $duzenle["mail"] ?? '' ?>"
class="w-full p-3 rounded-lg bg-gray-800 outline-none"
required>

<input type="text"
name="telefon"
placeholder="Telefon"
value="<?= $duzenle["telefon"] ?? '' ?>"
class="w-full p-3 rounded-lg bg-gray-800 outline-none"
required>

<input type="text"
name="sifre"
placeholder="Şifre"
value="<?= $duzenle["sifre"] ?? '' ?>"
class="w-full p-3 rounded-lg bg-gray-800 outline-none"
required>

<?php if($duzenle){ ?>

<button name="guncelle"
class="w-full bg-yellow-500 hover:bg-yellow-600 py-3 rounded-lg font-semibold transition">
Kullanıcıyı Güncelle
</button>

<?php } else { ?>

<button name="ekle"
class="w-full bg-blue-600 hover:bg-blue-700 py-3 rounded-lg font-semibold transition">
Kullanıcı Ekle
</button>

<?php } ?>

</form>

</div>

<!-- KULLANICILAR -->
<div class="bg-gray-900 rounded-2xl p-6 shadow-2xl">

<h2 class="text-2xl font-bold mb-6">
Kullanıcılar
</h2>

<div class="space-y-4 max-h-[700px] overflow-y-auto pr-2">

<?php foreach ($kullanicilar as $k): ?>

<div class="bg-gray-800 p-5 rounded-xl">

<div class="flex justify-between items-start">

<div>

<div class="text-xl font-semibold">
<?= $k["isim"] ?>
</div>

<div class="text-blue-400 text-sm mt-1">
<?= $k["mail"] ?>
</div>

<div class="text-gray-400 text-sm mt-1">
<?= $k["telefon"] ?>
</div>

<div class="text-red-400 text-sm mt-2">
Şifre: <?= $k["sifre"] ?>
</div>

</div>

<div class="flex gap-2">

<a href="?duzenle_id=<?= $k["id"] ?>"
class="bg-yellow-500 hover:bg-yellow-600 px-4 py-2 rounded-lg transition">
Düzenle
</a>

<a href="?sil_id=<?= $k["id"] ?>"
class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg transition">
Sil
</a>

</div>

</div>

</div>

<?php endforeach; ?>

<?php if(count($kullanicilar) == 0){ ?>

<div class="text-center text-gray-400 py-10">
Henüz kullanıcı yok
</div>

<?php } ?>

</div>

</div>

</div>

</div>

</body>
</html>