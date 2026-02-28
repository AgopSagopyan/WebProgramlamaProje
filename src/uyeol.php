<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Üye Ol</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black min-h-screen flex items-center justify-center">

    <!-- KAYIT KARTI -->
    <div class="bg-gray-900 p-10 rounded-2xl shadow-2xl w-full max-w-md">

        <h1 class="text-3xl font-bold text-center mb-8 text-white">Üye Ol</h1>

        <!-- FORM -->
        <form class="space-y-5" id="uyeForm">

            <!-- İsim -->
            <div>
                <label class="block mb-2 text-white">İsim Soyisim</label>
                <input type="text" id="isim" placeholder="Adınız Soyadınız"
                       class="w-full p-3 rounded text-black focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p id="isimError" class="text-red-500 text-sm mt-1 hidden">
                    Sadece harf kullanabilirsiniz.
                </p>
            </div>

            <!-- Mail -->
            <div>
                <label class="block mb-2 text-white">Mail</label>
                <input type="text" id="mail" placeholder="ornek@mail.com"
                       class="w-full p-3 rounded text-black focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p id="mailError" class="text-red-500 text-sm mt-1 hidden">
                    Geçerli bir mail giriniz.
                </p>
            </div>

            <!-- Telefon -->
            <div>
                <label class="block mb-2 text-white">Telefon</label>
                <input type="text" id="telefon" placeholder="05xxxxxxxxx"
                       class="w-full p-3 rounded text-black focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p id="telefonError" class="text-red-500 text-sm mt-1 hidden">
                    10-11 haneli rakam giriniz.
                </p>
            </div>

            <!-- Şifre -->
            <div>
                <label class="block mb-2 text-white">Şifre</label>
                <input type="password" id="sifre" placeholder="********"
                       class="w-full p-3 rounded text-black focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p id="sifreError" class="text-red-500 text-sm mt-1 hidden">
                    Şifre en az 8 karakter olmalıdır.
                </p>
            </div>

            <!-- Kayıt Butonu -->
            <button type="button" id="kayitBtn"
                    class="w-full bg-blue-600 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                Kayıt Ol
            </button>

        </form>

    </div>

    <!-- TOAST MESAJI -->
    <div id="toast"
         class="fixed top-5 right-[-400px] px-6 py-4 rounded-lg shadow-lg text-white transition-all duration-500 whitespace-pre-line">
    </div>

    <!-- JAVASCRIPT -->
    <script>
    document.addEventListener("DOMContentLoaded", () => {

        const isim = document.getElementById("isim");
        const mail = document.getElementById("mail");
        const telefon = document.getElementById("telefon");
        const sifre = document.getElementById("sifre");
        const kayitBtn = document.getElementById("kayitBtn");
        const toast = document.getElementById("toast");

        // GERÇEK ZAMANLI VALIDATION
        isim.addEventListener("input", () => {
            const regex = /^[A-Za-zğüşöçıİĞÜŞÖÇ\s]+$/;
            if (!regex.test(isim.value)) {
                isim.classList.add("border-red-500");
                isim.classList.remove("border-green-500");
                document.getElementById("isimError").classList.remove("hidden");
            } else {
                isim.classList.remove("border-red-500");
                isim.classList.add("border-green-500");
                document.getElementById("isimError").classList.add("hidden");
            }
        });

        mail.addEventListener("input", () => {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!regex.test(mail.value)) {
                mail.classList.add("border-red-500");
                mail.classList.remove("border-green-500");
                document.getElementById("mailError").classList.remove("hidden");
            } else {
                mail.classList.remove("border-red-500");
                mail.classList.add("border-green-500");
                document.getElementById("mailError").classList.add("hidden");
            }
        });

        telefon.addEventListener("input", () => {
            const regex = /^[0-9]{10,11}$/;
            if (!regex.test(telefon.value)) {
                telefon.classList.add("border-red-500");
                telefon.classList.remove("border-green-500");
                document.getElementById("telefonError").classList.remove("hidden");
            } else {
                telefon.classList.remove("border-red-500");
                telefon.classList.add("border-green-500");
                document.getElementById("telefonError").classList.add("hidden");
            }
        });

        sifre.addEventListener("input", () => {
            if (sifre.value.length < 8) {
                sifre.classList.add("border-red-500");
                sifre.classList.remove("border-green-500");
                document.getElementById("sifreError").classList.remove("hidden");
            } else {
                sifre.classList.remove("border-red-500");
                sifre.classList.add("border-green-500");
                document.getElementById("sifreError").classList.add("hidden");
            }
        });

        // KAYIT BUTONU
        kayitBtn.addEventListener("click", () => {

            const isimValid = /^[A-Za-zğüşöçıİĞÜŞÖÇ\s]+$/.test(isim.value);
            const mailValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(mail.value);
            const telefonValid = /^[0-9]{10,11}$/.test(telefon.value);
            const sifreValid = sifre.value.length >= 8;

            if (isimValid && mailValid && telefonValid && sifreValid) {

            toast.className = "fixed top-5 px-6 py-4 rounded-lg shadow-lg text-white bg-green-600 transition-all duration-500 whitespace-pre-line";
    toast.innerHTML = `Başarı ile kayıt olundu ✅
Giriş Yapmak İçin Lütfen Tıklayınız
<span class="text-sm underline cursor-pointer" onclick="window.location.href='giris.php'">Giriş Yap</span>`;

} else {
    toast.className = "fixed top-5 px-6 py-4 rounded-lg shadow-lg text-white bg-red-600 transition-all duration-500 whitespace-pre-line";
    toast.innerHTML = `Kayıt işlemi başarısız ❌
Lütfen boş alanları doldurunuz.`;
}

            // SAĞDAN GELSİN
            toast.style.right = "20px";

            // 3 saniye sonra geri kaybolsun
            setTimeout(() => {
                toast.style.right = "-400px";
            }, 5000);

        });

    });
    </script>

</html>