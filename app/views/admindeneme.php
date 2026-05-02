<?php
include("baglan.php");

// EKLEME
if(isset($_POST["ekle"])){

    $ad = $_POST["film_adi"];
    $kategori = $_POST["kategori"];

    $resimAdi = $_FILES["resim"]["name"];
    $tmp = $_FILES["resim"]["tmp_name"];

    $klasor = "uploads/";

    if(!file_exists($klasor)){
        mkdir($klasor, 0777, true);
    }

    $yol = $klasor . $resimAdi;
    move_uploaded_file($tmp, $yol);

    $sql = "INSERT INTO filmler (film_adi, resim, kategori)
            VALUES ('$ad', '$yol', '$kategori')";

    $baglan->query($sql);
}

// SİLME
if(isset($_GET["sil"])){
    $id = $_GET["sil"];

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

<!-- 🔥 SIDEBAR -->
<div class="w-64 bg-gray-900 p-6 flex flex-col">

    <h2 class="text-white text-2xl font-bold mb-8">Admin Panel</h2>

    <nav class="space-y-4">
        <a href="kullanicilar.php" class="block text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded">
            Kullanıcılar
        </a>

        <a href="admindeneme.php" class="block text-white bg-gray-700 p-2 rounded">
            Filmler
        </a>

        <a href="biletadmin.php" class="block text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded">
            Rezervasyonlar
        </a>

        <a href="admin.php" class="block text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded">
            İstatistik
        </a>
    </nav>

    <div class="mt-auto">
        <a href="anasayfa.php" class="block text-red-400 hover:text-red-300 p-2 rounded mt-8">
            Çıkış Yap
        </a>
    </div>

</div>

<!-- 🔥 SAĞ İÇERİK -->
<div class="flex-1 p-10 text-white">

<div class="grid grid-cols-1 md:grid-cols-2 gap-10">

<!-- SOL: EKLE -->
<div class="bg-gray-900 p-6 rounded-xl shadow-lg">

<h2 class="text-xl font-semibold mb-4">Film Ekle</h2>

<form method="POST" enctype="multipart/form-data" class="space-y-4">

<input type="text" name="film_adi" placeholder="Film Adı"
class="w-full p-3 rounded bg-gray-800 outline-none" required>

<input type="file" name="resim"
class="w-full p-3 rounded bg-gray-800 outline-none" required>

<input type="text" name="kategori" placeholder="Kategori"
class="w-full p-3 rounded bg-gray-800 outline-none" required>

<button name="ekle"
class="w-full bg-blue-600 py-3 rounded-lg hover:bg-blue-700 transition">
Film Ekle
</button>

</form>

</div>

<!-- SAĞ: LİSTE -->
<div class="bg-gray-900 p-6 rounded-xl shadow-lg">

<h2 class="text-xl font-semibold mb-4">Filmler</h2>

<div class="space-y-4 max-h-[500px] overflow-y-auto">

<?php
$sql = "SELECT * FROM filmler ORDER BY id DESC";
$sonuc = $baglan->query($sql);

while($row = $sonuc->fetch_assoc()){
?>

<div class="flex items-center justify-between bg-gray-800 p-3 rounded-lg hover:bg-gray-700 transition">

<div class="flex items-center gap-4">

<img src="<?php echo $row["resim"]; ?>"
class="w-16 h-16 object-cover rounded">

<div>
<div class="font-semibold"><?php echo $row["film_adi"]; ?></div>
<div class="text-sm text-gray-400"><?php echo $row["kategori"]; ?></div>
</div>

</div>

<a href="?sil=<?php echo $row["id"]; ?>"
class="bg-red-600 px-4 py-2 rounded hover:bg-red-700">
Sil
</a>

</div>

<?php } ?>

</div>

</div>

</div>

</div>

</body>
</html>