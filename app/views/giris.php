<?php
$hata = "";

// Formdan veri geldiyse işle
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = $_POST["mail"];
    $sifre = $_POST["sifre"];

    require "baglanti.php";

    // Kullanıcıyı veritabanında ara
    $stmt = $pdo->prepare("SELECT * FROM kullanicilar WHERE mail = :mail");
    $stmt->execute(['mail' => $mail]);
    $kullanici = $stmt->fetch();

    if ($kullanici && $kullanici['sifre'] == $sifre) {
        // Başarıyla giriş yaptı
        session_start();
        $_SESSION['kullanici_id'] = $kullanici['id'];
        $_SESSION['kullanici_isim'] = $kullanici['isim'];

        // Giriş başarılı olduktan sonra anasayfaya yönlendirme
        header('Location: anasayfa.php');
        exit();
    } else {
        // Hata mesajı
        $hata = "❌ Giriş başarısız! Lütfen bilgilerinizi kontrol edin.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-black min-h-screen flex items-center justify-center">

    <div class="bg-gray-900 p-10 rounded-2xl shadow-2xl w-full max-w-md text-white">

        <h1 class="text-3xl font-bold text-center mb-8">Giriş Yap</h1>

        <form method="POST" action="giris.php">
            <input id="mail" name="mail" class="w-full p-3 mb-4 rounded text-black focus:ring-2 focus:ring-blue-500" placeholder="Mail" required>
            <input id="sifre" name="sifre" type="password" class="w-full p-3 mb-6 rounded text-black focus:ring-2 focus:ring-blue-500" placeholder="Şifre" required>

            <!-- Hata mesajı -->
            <?php if ($hata): ?>
                <div class="text-red-400 text-center mb-4"><?= $hata ?></div>
            <?php endif; ?>

            <button type="submit" class="w-full bg-blue-600 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                Giriş Yap
            </button>
        </form>
    </div>

</body>
</html>