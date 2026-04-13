<?php
include("baglan.php");

// EKLEME
if(isset($_POST["ekle"])){

    $ad = $_POST["film_adi"];
    $kategori = $_POST["kategori"];

    // RESİM YÜKLEME
    $resimAdi = $_FILES["resim"]["name"];
    $tmp = $_FILES["resim"]["tmp_name"];

    $klasor = "uploads/";

    // klasör yoksa oluştur
    if(!file_exists($klasor)){
        mkdir($klasor, 0777, true);
    }

    $yol = $klasor . $resimAdi;

    move_uploaded_file($tmp, $yol);

    // VERİTABANI
    $sql = "INSERT INTO filmler (film_adi, resim, kategori)
            VALUES ('$ad', '$yol', '$kategori')";

    $baglan->query($sql);
}

// SİLME
if(isset($_GET["sil"])){
    $id = $_GET["sil"];

    // önce bağlı biletleri sil
    $baglan->query("DELETE FROM biletler WHERE film_id=$id");

    // sonra filmi sil
    $baglan->query("DELETE FROM filmler WHERE id=$id");
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Admin Panel</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white">

<div class="max-w-6xl mx-auto mt-10 grid grid-cols-1 md:grid-cols-2 gap-10">

<!-- SOL: EKLE -->
<div class="bg-gray-800 p-6 rounded-xl shadow-lg">

<h2 class="text-xl font-semibold mb-4">Film Ekle</h2>

<form method="POST" enctype="multipart/form-data" class="space-y-4">

<input type="text" name="film_adi" placeholder="Film Adı"
class="w-full p-3 rounded bg-gray-700 outline-none" required>

<input type="file" name="resim"
class="w-full p-3 rounded bg-gray-700 outline-none" required>

<input type="text" name="kategori" placeholder="Kategori"
class="w-full p-3 rounded bg-gray-700 outline-none" required>

<button name="ekle"
class="w-full bg-blue-600 py-3 rounded-lg hover:bg-blue-700 transition">
Film Ekle
</button>

</form>

</div>

<!-- SAĞ: LİSTE -->
<div class="bg-gray-800 p-6 rounded-xl shadow-lg">

<h2 class="text-xl font-semibold mb-4">Filmler</h2>

<div class="space-y-4 max-h-[500px] overflow-y-auto">

<?php
$sql = "SELECT * FROM filmler ORDER BY id DESC";
$sonuc = $baglan->query($sql);

while($row = $sonuc->fetch_assoc()){
?>

<div class="flex items-center justify-between bg-gray-700 p-3 rounded-lg">

<div class="flex items-center gap-4">

<img src="<?php echo $row["resim"]; ?>"
class="w-16 h-16 object-cover rounded">

<div>
<div class="font-semibold"><?php echo $row["film_adi"]; ?></div>
<div class="text-sm text-gray-300"><?php echo $row["kategori"]; ?></div>
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

</body>
</html>