<?php
// Hata mesajlarını tutmak için
$hata = "";

// Formdan veri geldiyse işle
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kullanıcıdan gelen veriler
    $isim = $_POST["isim"];
    $mail = $_POST["mail"];
    $telefon = $_POST["telefon"];
    $sifre = $_POST["sifre"];

    // Mail formatı kontrolü
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $hata = "❌ Lütfen geçerli bir e-posta adresi girin.";
    }

    // Eğer hata yoksa veritabanına kaydet
    if (empty($hata)) {
        require "baglanti.php";
        
        // Kullanıcı verilerini veritabanına ekle
        $sql = "INSERT INTO kullanicilar (isim, mail, telefon, sifre) VALUES (:isim, :mail, :telefon, :sifre)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'isim' => $isim,
            'mail' => $mail,
            'telefon' => $telefon,
            'sifre' => $sifre // Şifreyi düz metin olarak kaydediyoruz
        ]);

        // Başarı mesajı
        header('Location: giris.php'); // Başarılı kayıttan sonra giriş sayfasına yönlendir
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Üye Ol</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-black min-h-screen flex items-center justify-center">

    <div class="bg-gray-900 p-10 rounded-2xl shadow-2xl w-full max-w-md text-white">

        <h1 class="text-3xl font-bold text-center mb-8">Üye Ol</h1>

        <!-- Kayıt Formu -->
        <form method="POST" action="uyeol.php">
            <input id="isim" name="isim" class="w-full p-3 mb-4 rounded text-black focus:ring-2 focus:ring-blue-500" placeholder="İsim Soyisim" required>
            <input id="mail" name="mail" class="w-full p-3 mb-4 rounded text-black focus:ring-2 focus:ring-blue-500" placeholder="Mail" required>
            <input id="telefon" name="telefon" class="w-full p-3 mb-4 rounded text-black focus:ring-2 focus:ring-blue-500" placeholder="Telefon" required>
            <input id="sifre" name="sifre" type="password" class="w-full p-3 mb-6 rounded text-black focus:ring-2 focus:ring-blue-500" placeholder="Şifre" required>

            <!-- Hata mesajı -->
            <?php if ($hata): ?>
                <div class="p-3 mb-4 text-red-400 text-center"><?= $hata ?></div>
            <?php endif; ?>

            <!-- Kayıt Butonu -->
            <button type="submit" class="w-full bg-blue-600 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                Kayıt Ol
            </button>
        </form>

    </div>

</body>
</html>