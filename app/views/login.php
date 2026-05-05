<?php
session_start();
include("baglan.php");

$hata = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $kullanici = $_POST["kullanici"];
    $sifre = $_POST["sifre"];

    $stmt = $baglan->prepare("SELECT * FROM adminler WHERE kullanici=? AND sifre=?");
    $stmt->bind_param("ss", $kullanici, $sifre);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows == 1){

        $_SESSION["admin"] = true;
        $_SESSION["kullanici"] = $kullanici;

        header("Location: admin.php");
        exit;

    } else {
        $hata = "Kullanıcı adı veya şifre yanlış ❌";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Admin Login</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-black flex items-center justify-center h-screen">

<div class="bg-gray-900 p-10 rounded-2xl w-96 shadow-xl">

    <h1 class="text-white text-2xl mb-6 text-center font-bold">
        Admin Giriş
    </h1>

    <?php if($hata != "") { ?>
        <div class="bg-red-600 text-white p-2 rounded mb-4 text-center">
            <?= $hata ?>
        </div>
    <?php } ?>

    <form method="POST" class="space-y-4">

        <input type="text" name="kullanici"
            placeholder="Kullanıcı Adı"
            class="w-full p-3 bg-gray-800 text-white rounded">

        <input type="password" name="sifre"
            placeholder="Şifre"
            class="w-full p-3 bg-gray-800 text-white rounded">

        <button class="w-full bg-blue-600 p-3 rounded hover:bg-blue-700">
            Giriş Yap
        </button>

    </form>

</div>

</body>
</html>