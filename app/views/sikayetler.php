<?php
include("baglan.php");

if(isset($_GET["islem"]) && isset($_GET["id"])){

    $id = (int) $_GET["id"];

    if($_GET["islem"] == "okundu"){
        $stmt = $baglan->prepare("UPDATE sikayetler SET okundu=1 WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    if($_GET["islem"] == "sil"){
        $stmt = $baglan->prepare("DELETE FROM sikayetler WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    header("Location: sikayetler.php");
    exit;
}


$result = $baglan->query("SELECT * FROM sikayetler ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Şikayetler</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-black min-h-screen flex">

<!--  SIDEBAR -->
<div class="w-64 bg-gray-900 p-6 flex flex-col">

    <h2 class="text-white text-2xl font-bold mb-8">Admin Panel</h2>

    <nav class="space-y-4">
        <a href="kullanicilar.php" class="block text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded">Kullanıcılar</a>
        <a href="admindeneme.php" class="block text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded">Filmler</a>
        <a href="biletadmin.php" class="block text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded">Rezervasyonlar</a>
        <a href="sikayetler.php" class="block text-white bg-gray-700 p-2 rounded">Şikayetler</a>
        <a href="admin.php" class="block text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded">İstatistik</a>
    </nav>

    <div class="mt-auto">
        <a href="anasayfa.php" class="block text-red-400 hover:text-red-300 p-2 rounded mt-8">
            Çıkış Yap
        </a>
    </div>

</div>

<!--  SAĞ İÇERİK -->
<div class="flex-1 p-10 text-white">

<h1 class="text-3xl mb-6 font-bold"> Şikayetler</h1>

<div class="bg-gray-900 rounded-2xl shadow-2xl overflow-hidden">

<table class="w-full text-left">

<thead class="bg-gray-800 text-gray-300 uppercase text-sm">
<tr>
    <th class="p-4">ID</th>
    <th class="p-4">İsim</th>
    <th class="p-4">Şikayet</th>
    <th class="p-4">Durum</th>
    <th class="p-4">İşlem</th>
</tr>
</thead>

<tbody>

<?php while($row = $result->fetch_assoc()) { ?>
<tr class="border-b border-gray-800 hover:bg-gray-800 transition">

    <td class="p-4"><?= $row["id"] ?></td>

    <td class="p-4 font-semibold"><?= $row["isim"] ?></td>

    <td class="p-4 text-gray-300"><?= $row["mesaj"] ?></td>

    <!-- DURUM -->
    <td class="p-4">
        <?php if($row["okundu"] == 0){ ?>
            <span class="bg-red-600 px-2 py-1 rounded text-sm">Okunmadı</span>
        <?php } else { ?>
            <span class="bg-green-600 px-2 py-1 rounded text-sm">Okundu</span>
        <?php } ?>
    </td>

    <!-- BUTONLAR -->
    <td class="p-4 space-x-2">

        <?php if($row["okundu"] == 0){ ?>
        <a href="?islem=okundu&id=<?= $row["id"] ?>"
           class="bg-blue-600 px-3 py-1 rounded hover:bg-blue-700 transition">
           Okundu
        </a>
        <?php } ?>

        <a href="?islem=sil&id=<?= $row["id"] ?>"
           class="bg-red-600 px-3 py-1 rounded hover:bg-red-700 transition"
           onclick="return confirm('Silmek istediğine emin misin?')">
           Sil
        </a>

    </td>

</tr>
<?php } ?>

</tbody>

</table>

<?php if($result->num_rows == 0): ?>
<div class="p-10 text-center text-gray-400">
    Henüz şikayet yok 👍
</div>
<?php endif; ?>

</div>

</div>

</body>
</html>