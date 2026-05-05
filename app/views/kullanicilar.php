<?php
require "baglan.php";

// Kullanıcıları çek
$kullanicilar = $pdo->query("SELECT * FROM kullanicilar ORDER BY id DESC")->fetchAll();

// Silme işlemi
if (isset($_GET['sil_id'])) {
    $sil_id = $_GET['sil_id'];

    $sql = "DELETE FROM kullanicilar WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $sil_id]);

    header("Location: kullanicilar.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Kullanıcılar</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-black min-h-screen flex">

<!--SIDEBAR -->
<div class="w-64 bg-gray-900 p-6 flex flex-col">

    <h2 class="text-white text-2xl font-bold mb-8">Admin Panel</h2>

    <nav class="space-y-4">
        <a href="kullanicilar.php" class="block text-white bg-gray-700 p-2 rounded">
            Kullanıcılar
        </a>

        <a href="admindeneme.php" class="block text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded">
            Filmler
        </a>

        <a href="biletadmin.php" class="block text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded">
            Rezervasyonlar
        </a>

          <a href="sikayetler.php" class="block text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded">
                Şikayetler
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

<!-- SAĞ İÇERİK -->
<div class="flex-1 p-10 text-white">

    <!-- ÜST BAR -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold"> Kullanıcılar</h1>

        <a href="uyeol.php" class="bg-blue-600 px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            + Yeni Üye
        </a>
    </div>

    <!-- TABLO -->
    <div class="bg-gray-900 rounded-2xl shadow-2xl overflow-hidden">

        <table class="w-full text-left">

            <thead class="bg-gray-800 text-gray-300 uppercase text-sm">
                <tr>
                    <th class="p-4">ID</th>
                    <th class="p-4">İsim</th>
                    <th class="p-4">Mail</th>
                    <th class="p-4">Telefon</th>
                    <th class="p-4">Şifre</th>
                    <th class="p-4">Sil</th>
                </tr>
            </thead>

            <tbody>

            <?php foreach ($kullanicilar as $k): ?>
            <tr class="border-b border-gray-800 hover:bg-gray-800 transition">

                <td class="p-4"><?= $k["id"] ?></td>

                <td class="p-4 font-semibold"><?= $k["isim"] ?></td>

                <td class="p-4 text-blue-400"><?= $k["mail"] ?></td>

                <td class="p-4"><?= $k["telefon"] ?></td>

                <td class="p-4 text-gray-400"><?= $k["sifre"] ?></td>

                <td class="p-4">
                    <a href="kullanicilar.php?sil_id=<?= $k["id"] ?>"
                    class="bg-red-600 px-3 py-1 rounded-lg hover:bg-red-700 transition">
                        Sil
                    </a>
                </td>

            </tr>
            <?php endforeach; ?>

            </tbody>
        </table>

        <?php if (count($kullanicilar) == 0): ?>
        <div class="p-10 text-center text-gray-400">
            Henüz kullanıcı yok 😢
        </div>
        <?php endif; ?>

    </div>

</div>

</body>
</html>