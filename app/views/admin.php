<?php
include("baglan.php");

// TOPLAM KULLANICI
$kullaniciSorgu = $baglan->query("SELECT COUNT(*) as toplam FROM kullanicilar");
$kullaniciSayisi = $kullaniciSorgu->fetch_assoc()['toplam'];

// TOPLAM FİLM
$filmSorgu = $baglan->query("SELECT COUNT(*) as toplam FROM filmler");
$filmSayisi = $filmSorgu->fetch_assoc()['toplam'];

// TOPLAM REZERVASYON
$rezSorgu = $baglan->query("SELECT COUNT(*) as toplam FROM biletler");
$rezSayisi = $rezSorgu->fetch_assoc()['toplam'];
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black min-h-screen flex">

    <!-- SOL MENÜ -->
    <div class="w-64 bg-gray-900 p-6 flex flex-col">

        <h2 class="text-white text-2xl font-bold mb-8">Admin Panel</h2>

        <nav class="space-y-4">
            <a href="kullanicilar.php" class="block text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded">
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

            <a href="#" class="block text-white bg-gray-700 p-2 rounded">
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
    <div class="flex-1 p-10">

        <h1 class="text-3xl font-bold text-white mb-6">
            Hoş Geldin Admin 
        </h1>

        <div class="grid grid-cols-3 gap-6">

            <!-- Kullanıcı -->
            <div class="bg-gray-900 p-6 rounded-xl shadow hover:scale-105 transition">
                <h3 class="text-gray-400">Toplam Kullanıcı</h3>
                <p class="text-3xl text-white mt-2">
                    <?php echo $kullaniciSayisi; ?>
                </p>
            </div>

            <!-- Film -->
            <div class="bg-gray-900 p-6 rounded-xl shadow hover:scale-105 transition">
                <h3 class="text-gray-400">Toplam Film</h3>
                <p class="text-3xl text-white mt-2">
                    <?php echo $filmSayisi; ?>
                </p>
            </div>

            <!-- Rezervasyon -->
            <div class="bg-gray-900 p-6 rounded-xl shadow hover:scale-105 transition">
                <h3 class="text-gray-400">Rezervasyon</h3>
                <p class="text-3xl text-white mt-2">
                    <?php echo $rezSayisi; ?>
                </p>
            </div>

        </div>

    </div>

</body>
</html>