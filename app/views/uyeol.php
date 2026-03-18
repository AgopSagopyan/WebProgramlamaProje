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

<input id="isim" class="w-full p-3 mb-4 rounded text-black focus:ring-2 focus:ring-blue-500" placeholder="İsim Soyisim">
<input id="mail" class="w-full p-3 mb-4 rounded text-black focus:ring-2 focus:ring-blue-500" placeholder="Mail">
<input id="telefon" class="w-full p-3 mb-4 rounded text-black focus:ring-2 focus:ring-blue-500" placeholder="Telefon">
<input id="sifre" type="password" class="w-full p-3 mb-6 rounded text-black focus:ring-2 focus:ring-blue-500" placeholder="Şifre">

<button id="btn" class="w-full bg-blue-600 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
Kayıt Ol
</button>

<div id="sonuc" class="mt-6 text-center text-lg"></div>

</div>

<script>
document.getElementById("btn").addEventListener("click", () => {

    let isim = document.getElementById("isim").value;
    let mail = document.getElementById("mail").value;
    let telefon = document.getElementById("telefon").value;
    let sifre = document.getElementById("sifre").value;

    fetch("kayit.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `isim=${isim}&mail=${mail}&telefon=${telefon}&sifre=${sifre}`
    })
    .then(res => res.text())
    .then(data => {

        if (data === "success") {
            document.getElementById("sonuc").innerHTML = "<span class='text-green-400'>✅ Kayıt başarılı</span>";
        } else {
            document.getElementById("sonuc").innerHTML = "<span class='text-red-400'>❌ " + data + "</span>";
        }

    });

});
</script>

</body>
</html>