<?php
include("baglan.php");

$mesajDurum = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $isim = trim($_POST["isim"]);
    $mesaj = trim($_POST["mesaj"]);

    if (empty($isim) || empty($mesaj)) {
        $mesajDurum = "<div class='bg-red-600 p-3 rounded mb-4'>Boş alan bırakmayın ❌</div>";
    } else {

        $stmt = $baglan->prepare("INSERT INTO sikayetler (isim, mesaj) VALUES (?, ?)");
        $stmt->bind_param("ss", $isim, $mesaj);

        if ($stmt->execute()) {
            $mesajDurum = "<div class='bg-green-600 p-3 rounded mb-4'>Başarıyla gönderildi ✅</div>";
        } else {
            $mesajDurum = "<div class='bg-red-600 p-3 rounded mb-4'>Hata oluştu ❌</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>İletişim</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-black text-white">

<div class="max-w-4xl mx-auto mt-12 bg-gray-900 rounded-2xl p-10">

    <h1 class="text-3xl font-bold mb-6 text-center">
        Şikayet Bildir
    </h1>

    <!-- MESAJ -->
    <?= $mesajDurum ?>

    <form method="POST" class="space-y-5">

        <!-- İsim -->
        <div>
            <label class="block mb-2 font-semibold">İsim Soyisim</label>
            <input type="text" name="isim"
                class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3">
        </div>

        <!-- Şikayet -->
        <div>
            <label class="block mb-2 font-semibold">Şikayetiniz</label>
            <textarea name="mesaj" rows="5"
                class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3"></textarea>
        </div>

        <button type="submit"
            class="w-full bg-blue-600 py-3 rounded-lg hover:bg-blue-700">
            Gönder
        </button>

    </form>

    <!-- HAKKIMIZDA-->
    <div class="mt-10 border-t border-gray-700 py-6 text-center">
        <h2 class="text-lg font-semibold mb-3">Hakkımızda</h2>
        <p class="text-gray-400 text-sm">
            Etkinlik rezervasyon platformumuz; film, konser ve bowling
            organizasyonlarını kolayca rezerve etmenizi sağlar.
        </p>
    </div>

</div>

</body>
</html>