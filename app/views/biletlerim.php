<?php
session_start();
include("baglan.php");

/* COOKIE → SESSION AKTAR */
if(!isset($_SESSION['kullanici_email']) && isset($_COOKIE['kullanici_email'])){
    $_SESSION['kullanici_email'] = $_COOKIE['kullanici_email'];
}

/* LOGIN KONTROL */
if(!isset($_SESSION['kullanici_email'])){
    header("Location: giris.php");
    exit;
}

$email = $_SESSION['kullanici_email'];

/* BİLET İPTAL */
if(isset($_GET["iptal"])){

    $id = (int)$_GET["iptal"];

    $sil = $baglan->prepare("DELETE FROM biletler WHERE id=? AND email=?");
    $sil->bind_param("is", $id, $email);
    $sil->execute();

    $_SESSION["mesaj"] = "Bilet başarıyla iptal edildi.";

    header("Location: biletlerim.php");
    exit;
}

/* BİLETLERİ ÇEK */
$sql = "SELECT b.*, f.film_adi 
        FROM biletler b
        JOIN filmler f ON b.film_id = f.id
        WHERE b.email = ?
        ORDER BY b.id DESC";

$stmt = $baglan->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Biletlerim</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-black text-white p-10">

<h1 class="text-3xl font-bold mb-8">🎟 Biletlerim</h1>

<?php if(isset($_SESSION["mesaj"])){ ?>

<div class="bg-green-600 text-white p-4 rounded-xl mb-6">
    <?= $_SESSION["mesaj"] ?>
</div>

<?php unset($_SESSION["mesaj"]); } ?>

<div class="grid gap-6">

<?php if($result->num_rows > 0){ ?>

<?php while($row = $result->fetch_assoc()){ ?>

<div class="bg-gray-900 p-6 rounded-xl shadow">

<h2 class="text-red-400 text-xl mb-2">
    <?= $row['film_adi'] ?>
</h2>

<p><b>Salon:</b> <?= $row['konum'] ?></p>

<p><b>Seans:</b> <?= $row['seans'] ?></p>

<p><b>Koltuk:</b> <?= $row['koltuklar'] ?></p>

<p><b>Adet:</b> <?= $row['adet'] ?></p>

<a href="?iptal=<?= $row['id'] ?>"
   onclick="return confirm('Bileti iptal etmek istiyor musunuz?')"
   class="inline-block mt-4 bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg transition">

   Bileti İptal Et

</a>

</div>

<?php } ?>

<?php } else { ?>

<p class="text-gray-400">Henüz biletiniz yok.</p>

<?php } ?>

</div>

</body>
</html>