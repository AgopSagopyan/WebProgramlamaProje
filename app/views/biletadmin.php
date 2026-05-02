<?php
include("baglan.php");

// Biletleri çek
$sql = "SELECT biletler.*, filmler.film_adi FROM biletler
        JOIN filmler ON biletler.film_id = filmler.id
        ORDER BY tarih DESC";
$result = $baglan->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Rezervasyonlar</title>
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

        <a href="admindeneme.php" class="block text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded">
            Filmler
        </a>

        <a href="biletadmin.php" class="block text-white bg-gray-700 p-2 rounded">
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

    <h1 class="text-3xl font-bold mb-6"> Rezervasyonlar</h1>

    <div class="bg-gray-900 rounded-2xl shadow-2xl overflow-hidden">

        <table class="w-full text-center">

            <!-- HEADER -->
            <thead class="bg-gray-800 text-gray-300 text-sm uppercase">
                <tr>
                    <th class="p-3">ID</th>
                    <th class="p-3">Film</th>
                    <th class="p-3">Konum</th>
                    <th class="p-3">Seans</th>
                    <th class="p-3">Koltuklar</th>
                    <th class="p-3">İsim</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Adet</th>
                    <th class="p-3">Tarih</th>
                    <th class="p-3">İşlem</th>
                </tr>
            </thead>

            <!-- BODY -->
            <tbody>

            <?php while($row = $result->fetch_assoc()): ?>
            <tr class="border-b border-gray-800 hover:bg-gray-800 transition">

                <td class="p-3"><?= $row['id']; ?></td>
                <td class="p-3 font-semibold"><?= $row['film_adi']; ?></td>
                <td class="p-3"><?= $row['konum']; ?></td>
                <td class="p-3"><?= $row['seans']; ?></td>
                <td class="p-3 text-red-400"><?= $row['koltuklar']; ?></td>
                <td class="p-3"><?= $row['isim']; ?></td>
                <td class="p-3 text-blue-400"><?= $row['email']; ?></td>
                <td class="p-3"><?= $row['adet']; ?></td>
                <td class="p-3 text-gray-400"><?= $row['tarih']; ?></td>

                <td class="p-3">
                    <button class="silBtn bg-red-600 px-3 py-1 rounded hover:bg-red-700 transition"
                        data-id="<?= $row['id']; ?>">
                        Sil
                    </button>
                </td>

            </tr>
            <?php endwhile; ?>

            </tbody>
        </table>

        <?php if($result->num_rows == 0): ?>
        <div class="p-10 text-center text-gray-400">
            Henüz rezervasyon yok 😢
        </div>
        <?php endif; ?>

    </div>

</div>

<!-- 🔥 JS SİLME -->
<script>
const silBtns = document.querySelectorAll(".silBtn");

silBtns.forEach(btn=>{
    btn.addEventListener("click", ()=>{
        const id = btn.dataset.id;

        if(confirm("Bu bileti silmek istiyor musun?")){
            fetch("bilet_sil.php?id="+id)
            .then(res=>res.text())
            .then(()=>{
                btn.closest("tr").remove();
            });
        }
    });
});
</script>

</body>
</html>