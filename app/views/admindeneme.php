<?php
include("baglan.php");

/* EKLE */
if(isset($_POST["ekle"])){

    $ad = $_POST["film_adi"];
    $kategori = $_POST["kategori"];
    $aciklama = $_POST["aciklama"];
    $fiyat = $_POST["fiyat"];

    $resimAdi = $_FILES["resim"]["name"];
    $tmp = $_FILES["resim"]["tmp_name"];

    $klasor = "uploads/";

    if(!file_exists($klasor)){
        mkdir($klasor, 0777, true);
    }

    $yol = $klasor . time() . "_" . $resimAdi;

    move_uploaded_file($tmp, $yol);

    $sql = "INSERT INTO filmler 
    (film_adi, resim, kategori, aciklama, fiyat)
    VALUES 
    ('$ad', '$yol', '$kategori', '$aciklama', '$fiyat')";

    $baglan->query($sql);
}

/* GÜNCELLE */
if(isset($_POST["guncelle"])){

    $id = $_POST["film_id"];
    $ad = $_POST["film_adi"];
    $kategori = $_POST["kategori"];
    $aciklama = $_POST["aciklama"];
    $fiyat = $_POST["fiyat"];

    // ESKİ RESMİ ÇEK
    $resimSorgu = $baglan->query("SELECT resim FROM filmler WHERE id=$id");
    $eski = $resimSorgu->fetch_assoc();

    $yol = $eski["resim"];

    // YENİ RESİM GELDİYSE
    if(!empty($_FILES["resim"]["name"])){

        $resimAdi = $_FILES["resim"]["name"];
        $tmp = $_FILES["resim"]["tmp_name"];

        $klasor = "uploads/";

        $yol = $klasor . time() . "_" . $resimAdi;

        move_uploaded_file($tmp, $yol);
    }

    $sql = "UPDATE filmler SET
    film_adi='$ad',
    kategori='$kategori',
    aciklama='$aciklama',
    fiyat='$fiyat',
    resim='$yol'
    WHERE id=$id";

    $baglan->query($sql);
}

/* SİL */
if(isset($_GET["sil"])){

    $id = intval($_GET["sil"]);

    $baglan->query("DELETE FROM biletler WHERE film_id=$id");
    $baglan->query("DELETE FROM filmler WHERE id=$id");
}

/* DÜZENLENECEK FİLM */
$duzenleFilm = null;

if(isset($_GET["duzenle"])){

    $id = intval($_GET["duzenle"]);

    $sonuc = $baglan->query("SELECT * FROM filmler WHERE id=$id");

    $duzenleFilm = $sonuc->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Film Yönetimi</title>
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
class="block text-gray-300 hover:bg-gray-700 p-2 rounded">
Kullanıcılar
</a>

<a href="admindeneme.php"
class="block text-white bg-gray-700 p-2 rounded">
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

<a href="anasayfa.php"
class="mt-auto text-red-400 p-2">
Çıkış
</a>

</div>

<!-- SAĞ -->
<div class="flex-1 p-10 text-white">

<div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

<!-- FORM -->
<div class="bg-gray-900 p-6 rounded-2xl shadow-2xl">

<h2 class="text-2xl font-bold mb-6">

<?php if($duzenleFilm){ ?>
Film Güncelle
<?php } else { ?>
Film Ekle
<?php } ?>

</h2>

<form method="POST"
enctype="multipart/form-data"
class="space-y-4">

<?php if($duzenleFilm){ ?>

<input type="hidden"
name="film_id"
value="<?= $duzenleFilm["id"] ?>">

<?php } ?>

<input type="text"
name="film_adi"
placeholder="Film Adı"
value="<?= $duzenleFilm['film_adi'] ?? '' ?>"
class="w-full p-3 bg-gray-800 rounded-lg outline-none"
required>

<input type="file"
name="resim"
class="w-full p-3 bg-gray-800 rounded-lg">

<select name="kategori"
class="w-full p-3 bg-gray-800 rounded-lg"
required>

<option value="">Kategori Seç</option>

<option value="Aksiyon"
<?= (isset($duzenleFilm) && $duzenleFilm["kategori"]=="Aksiyon") ? "selected" : "" ?>>
Aksiyon
</option>

<option value="Komedi"
<?= (isset($duzenleFilm) && $duzenleFilm["kategori"]=="Komedi") ? "selected" : "" ?>>
Komedi
</option>

<option value="Korku"
<?= (isset($duzenleFilm) && $duzenleFilm["kategori"]=="Korku") ? "selected" : "" ?>>
Korku
</option>

<option value="Bilim Kurgu"
<?= (isset($duzenleFilm) && $duzenleFilm["kategori"]=="Bilim Kurgu") ? "selected" : "" ?>>
Bilim Kurgu
</option>

</select>

<textarea
name="aciklama"
placeholder="Film Açıklaması"
class="w-full p-3 bg-gray-800 rounded-lg h-40 resize-none outline-none"
required><?= $duzenleFilm['aciklama'] ?? '' ?></textarea>

<input type="number"
name="fiyat"
placeholder="Bilet Fiyatı"
value="<?= $duzenleFilm['fiyat'] ?? '' ?>"
class="w-full p-3 bg-gray-800 rounded-lg outline-none"
required>

<?php if($duzenleFilm){ ?>

<button name="guncelle"
class="w-full bg-yellow-500 hover:bg-yellow-600 py-3 rounded-lg font-semibold transition">
Filmi Güncelle
</button>

<?php } else { ?>

<button name="ekle"
class="w-full bg-blue-600 hover:bg-blue-700 py-3 rounded-lg font-semibold transition">
Film Ekle
</button>

<?php } ?>

</form>

</div>

<!-- LİSTE -->
<div class="bg-gray-900 p-6 rounded-2xl shadow-2xl">

<h2 class="text-2xl font-bold mb-6">
Filmler
</h2>

<div class="space-y-4 max-h-[700px] overflow-y-auto pr-2">

<?php
$sonuc = $baglan->query("SELECT * FROM filmler ORDER BY id DESC");

while($row = $sonuc->fetch_assoc()){
?>

<div class="bg-gray-800 rounded-xl p-4">

<div class="flex gap-4">

<img src="<?= $row["resim"] ?>"
class="w-24 h-32 object-cover rounded-lg">

<div class="flex-1">

<h3 class="text-xl font-semibold">
<?= $row["film_adi"] ?>
</h3>

<p class="text-sm text-gray-400 mb-2">
<?= $row["kategori"] ?>
</p>

<p class="text-sm text-gray-300">
<?= mb_strimwidth($row["aciklama"],0,120,"...") ?>
</p>

<div class="mt-3 text-red-400 font-bold text-lg">
<?= $row["fiyat"] ?> ₺
</div>

</div>

</div>

<div class="mt-4 flex gap-3 justify-end">

<a href="?duzenle=<?= $row["id"] ?>"
class="bg-yellow-500 hover:bg-yellow-600 px-4 py-2 rounded-lg transition">
Düzenle
</a>

<a href="?sil=<?= $row["id"] ?>"
class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg transition">
Sil
</a>

</div>

</div>

<?php } ?>

</div>

</div>

</div>

</div>

</body>
</html>