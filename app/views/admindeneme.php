<?php
include("baglan.php");

/* EKLE */
if(isset($_POST["ekle"])){

    $ad = $_POST["film_adi"];
    $kategori = $_POST["kategori"];

    $resimAdi = $_FILES["resim"]["name"];
    $tmp = $_FILES["resim"]["tmp_name"];

    $klasor = "uploads/";

    if(!file_exists($klasor)){
        mkdir($klasor, 0777, true);
    }

    $yol = $klasor . $resimAdi; // SENİN ORJİNAL YAPIN (BOZULMADI)
    move_uploaded_file($tmp, $yol);

    $sql = "INSERT INTO filmler (film_adi, resim, kategori)
            VALUES ('$ad', '$yol', '$kategori')";

    $baglan->query($sql);
}

/* SİL */
if(isset($_GET["sil"])){
    $id = intval($_GET["sil"]);

    $baglan->query("DELETE FROM biletler WHERE film_id=$id");
    $baglan->query("DELETE FROM filmler WHERE id=$id");
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Filmler</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-black min-h-screen flex">

<!-- SOL -->
<div class="w-64 bg-gray-900 p-6 flex flex-col">

<h2 class="text-white text-2xl font-bold mb-8">Admin Panel</h2>

<nav class="space-y-4">
<a href="kullanicilar.php" class="block text-gray-300 hover:bg-gray-700 p-2 rounded">Kullanıcılar</a>
<a href="admindeneme.php" class="block text-white bg-gray-700 p-2 rounded">Filmler</a>
<a href="biletadmin.php" class="block text-gray-300 hover:bg-gray-700 p-2 rounded">Rezervasyonlar</a>
<a href="sikayetler.php" class="block text-gray-300 hover:bg-gray-700 p-2 rounded">Şikayetler</a>
<a href="admin.php" class="block text-gray-300 hover:bg-gray-700 p-2 rounded">İstatistik</a>
</nav>

<a href="anasayfa.php" class="mt-auto text-red-400 p-2">Çıkış</a>

</div>

<!-- SAĞ -->
<div class="flex-1 p-10 text-white">

<div class="grid grid-cols-1 md:grid-cols-2 gap-10">

<!-- EKLE -->
<div class="bg-gray-900 p-6 rounded-xl">

<h2 class="text-xl mb-4">Film Ekle</h2>

<form method="POST" enctype="multipart/form-data" class="space-y-4">

<input type="text" name="film_adi" placeholder="Film Adı"
class="w-full p-3 bg-gray-800 rounded" required>

<input type="file" name="resim"
class="w-full p-3 bg-gray-800 rounded" required>

<!-- KATEGORİ -->
<select name="kategori" class="w-full p-3 bg-gray-800 rounded" required>
<option value="">Kategori Seç</option>
<option value="Aksiyon">Aksiyon</option>
<option value="Komedi">Komedi</option>
<option value="Korku">Korku</option>
<option value="Bilim Kurgu">Bilim Kurgu</option>
</select>

<button name="ekle" class="w-full bg-blue-600 py-3 rounded">
Film Ekle
</button>

</form>

</div>

<!-- LİSTE -->
<div class="bg-gray-900 p-6 rounded-xl">

<h2 class="text-xl mb-4">Filmler</h2>

<div class="space-y-4 max-h-[500px] overflow-y-auto">

<?php
$sonuc = $baglan->query("SELECT * FROM filmler ORDER BY id DESC");

while($row = $sonuc->fetch_assoc()){
?>

<div class="flex justify-between bg-gray-800 p-3 rounded">

<div class="flex gap-4">
<img src="<?= $row["resim"] ?>" class="w-16 h-16 object-cover rounded">

<div>
<div><?= $row["film_adi"] ?></div>
<div class="text-sm text-gray-400"><?= $row["kategori"] ?></div>
</div>
</div>

<a href="?sil=<?= $row["id"] ?>" class="bg-red-600 px-3 py-1 rounded">Sil</a>

</div>

<?php } ?>

</div>

</div>

</div>
</div>

</body>
</html>