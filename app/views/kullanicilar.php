<?php
require "baglanti.php";
$kullanicilar = $pdo->query("SELECT * FROM kullanicilar ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Kullanıcılar</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-black text-white min-h-screen p-10">

<div class="flex justify-between items-center mb-8">
<h1 class="text-3xl font-bold">👥 Kullanıcılar</h1>
<a href="uyeol.php" class="bg-blue-600 px-4 py-2 rounded-lg hover:bg-blue-700 transition">
+ Yeni Üye
</a>
</div>

<div class="bg-gray-900 rounded-2xl shadow-2xl overflow-hidden">

<table class="w-full text-left">

<thead class="bg-gray-800 text-gray-300 uppercase text-sm">
<tr>
<th class="p-4">ID</th>
<th class="p-4">İsim</th>
<th class="p-4">Mail</th>
<th class="p-4">Telefon</th>
</tr>
</thead>

<tbody>

<?php foreach($kullanicilar as $k): ?>
<tr class="border-b border-gray-800 hover:bg-gray-800 transition">

<td class="p-4"><?= $k["id"] ?></td>

<td class="p-4 font-semibold"><?= $k["isim"] ?></td>

<td class="p-4 text-blue-400"><?= $k["mail"] ?></td>

<td class="p-4"><?= $k["telefon"] ?></td>

</tr>
<?php endforeach; ?>

</tbody>

</table>

<?php if(count($kullanicilar) == 0): ?>
<div class="p-10 text-center text-gray-400">
Henüz kullanıcı yok 😢
</div>
<?php endif; ?>

</div>

</body>
</html>