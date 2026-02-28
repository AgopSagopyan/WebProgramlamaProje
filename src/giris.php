<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black min-h-screen flex items-center justify-center">

    <!-- Kart -->
    <div class="bg-gray-900 w-full max-w-5xl rounded-2xl shadow-2xl flex overflow-hidden">

        <!-- Sol kısım -->
        <div class="w-1/2 p-12 flex flex-col justify-center">

            <h1 class="text-3xl font-bold text-white mb-8">Giriş Yap</h1>

            <form class="space-y-6">

                <!-- mail -->
                <div>
                    <label class="block text-white mb-2">Mail</label>
                    <input type="text" id="mail"
                           placeholder="ornek@mail.com"
                           class="w-full p-3 rounded text-black border-2 border-transparent focus:outline-none">
                    <p id="mailError" class="text-red-500 text-sm mt-1 hidden">
                        Geçerli bir mail giriniz.
                    </p>
                </div>

                <!-- Şifre -->
                <div>
                    <label class="block text-white mb-2">Şifre</label>
                    <input type="password" id="sifre"
                           placeholder="********"
                           class="w-full p-3 rounded text-black border-2 border-transparent focus:outline-none">
                    <p id="sifreError" class="text-red-500 text-sm mt-1 hidden">
                        Şifre boş bırakılamaz.
                    </p>
                </div>

                <button type="button" id="girisBtn"
                        class="w-full bg-blue-600 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Giriş Yap
                </button>

            </form>

        </div>

        <!-- Sağ foto -->
        <div class="w-1/2 bg-gray-800 flex items-center justify-center p-6">
            <div class="w-full h-full rounded-xl overflow-hidden shadow-lg border border-gray-700">
                <img src="https://images.unsplash.com/photo-1517602302552-471fe67acf66"
                     class="w-full h-full object-cover">
            </div>
        </div>

    </div>

    <!-- Toast -->
    <div id="toast"
         class="fixed top-5 right-[-400px] px-6 py-4 rounded-lg shadow-lg text-white transition-all duration-500 whitespace-pre-line">
    </div>

<script>
document.addEventListener("DOMContentLoaded", () => {

    const mail = document.getElementById("mail");
    const sifre = document.getElementById("sifre");
    const girisBtn = document.getElementById("girisBtn");
    const toast = document.getElementById("toast");

    // GERÇEK ZAMANLI MAIL KONTROL
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

    // ŞİFRE KONTROL
    sifre.addEventListener("input", () => {
        if (sifre.value.trim() === "") {
            sifre.classList.add("border-red-500");
            sifre.classList.remove("border-green-500");
            document.getElementById("sifreError").classList.remove("hidden");
        } else {
            sifre.classList.remove("border-red-500");
            sifre.classList.add("border-green-500");
            document.getElementById("sifreError").classList.add("hidden");
        }
    });

    // GİRİŞ BUTONU
   girisBtn.addEventListener("click", () => {

    const mailValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(mail.value);
    const sifreValid = sifre.value.trim() !== "";

    if (mailValid && sifreValid) {

        toast.className = "fixed top-5 px-6 py-4 rounded-lg shadow-lg text-white bg-green-600 transition-all duration-500 whitespace-pre-line";
        toast.innerHTML = "Giriş başarılı ✅\nYönlendiriliyorsunuz...";

        toast.style.right = "20px";

        // 2 saniye sonra yönlendir
        setTimeout(() => {
            window.location.href = "baba.php"; 
        }, 2000);

    } else {

        toast.className = "fixed top-5 px-6 py-4 rounded-lg shadow-lg text-white bg-red-600 transition-all duration-500 whitespace-pre-line";
        toast.innerHTML = "Giriş başarısız ❌\nBilgileri kontrol edin.";

        toast.style.right = "20px";

        setTimeout(() => {
            toast.style.right = "-400px";
        }, 5000);
    }

});

        // SAĞDAN GELSİN
        toast.style.right = "20px";

        setTimeout(() => {
            toast.style.right = "-400px";
        }, 5000);

    });

</script>

</body>
</html>