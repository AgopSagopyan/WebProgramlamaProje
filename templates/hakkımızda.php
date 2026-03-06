<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>İletişim</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-white">

    <!-- DIŞ ÇERÇEVE -->
    <div class="max-w-4xl mx-auto mt-12 bg-gray-900 shadow-2xl shadow-xl rounded-2xl p-10">

        <!-- iç çerçeve -->
        <div class="bg-gray-800 border-gray-700">

            <h1 class="text-3xl font-bold mb-6 text-center">
                Bize Ulaşın
            </h1>

            <form action="#" method="POST" class="space-y-5">

                <!-- İsim Soyisim -->
                <div>
                    <label class="block mb-2 font-semibold">
                        İsim Soyisim
                    </label>
                    <input type="text"
                        id="isim"
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Adınız Soyadınız">

                  <p id="isimError" class="text-red-500 text-sm mt-1 hidden">
        Sadece harf kullanabilirsiniz.
     </p>
                </div>

                <!-- Mail -->
                <div>
                    <label class="block mb-2 font-semibold">
                        Mail Adresi
                    </label>
                    <input type="email"
                        id="mail"
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="ornek@mail.com">

                 <p id="mailError" class="text-red-500 text-sm mt-1 hidden">
        Geçerli bir mail adresi giriniz.
    </p>

                </div>

                <!-- Telefon -->
                <div>
                    <label class="block mb-2 font-semibold">
                        Telefon Numarası
                    </label>
                    <input type="tel"
                        id="telefon"
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="05xx xxx xx xx">

                      <p id="telefonError" class="text-red-500 text-sm mt-1 hidden">
        Sadece rakam giriniz (10-11 hane).
    </p>
                </div>

                <!-- Buton -->
                <button type="button"
                id="submitBtn"
                    class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Gönder
                </button>

                <!-- Mesaj Kutusu -->
                <div id="toast"
                class="fixed top-5 right-5 px-6 py-4 rounded-lg shadow-lg text-white hidden transition duration-300">
                </div>

          <!-- HAKKIMIZDA -->
<div class="mt-auto border-t border-gray-700 py-6">
    <div class="max-w-xl mx-auto text-center">

        <h2 class="text-lg font-semibold mb-3">
            Hakkımızda
        </h2>

        <p class="text-gray-400 text-sm leading-6">
            Etkinlik rezervasyon platformumuz; film, konser ve bowling
            organizasyonlarını kolayca rezerve etmenizi sağlar.
            İşlem yapmadan önce bilgilerinizi kontrol etmeniz önerilir.
        </p>

        <p class="text-gray-600 text-xs mt-4">
            Bu platform bilgilendirme amaçlıdır.
        </p>

    </div>
</div>
    
    <script>
const isimInput = document.getElementById("isim");
const isimError = document.getElementById("isimError");

const telefonInput = document.getElementById("telefon");
const telefonError = document.getElementById("telefonError");

const mailInput = document.getElementById("mail");
const mailError = document.getElementById("mailError");

const submitBtn = document.getElementById("submitBtn");
const toast = document.getElementById("toast");

// İSİM KONTROL
isimInput.addEventListener("input", () => {
    const regex = /^[A-Za-zğüşöçıİĞÜŞÖÇ\s]+$/;

    if (!regex.test(isimInput.value)) {
        isimInput.classList.remove("border-gray-700");
        isimInput.classList.add("border-red-500");
        isimError.classList.remove("hidden");
    } else {
        isimInput.classList.remove("border-red-500");
        isimInput.classList.add("border-green-500");
        isimError.classList.add("hidden");
    }
});

// TELEFON KONTROL
telefonInput.addEventListener("input", () => {
    const regex = /^[0-9]{10,11}$/;

    if (!regex.test(telefonInput.value)) {
        telefonInput.classList.remove("border-gray-700");
        telefonInput.classList.add("border-red-500");
        telefonError.classList.remove("hidden");
    } else {
        telefonInput.classList.remove("border-red-500");
        telefonInput.classList.add("border-green-500");
        telefonError.classList.add("hidden");
    }
});

// MAİL KONTROL
mailInput.addEventListener("input", () => {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!regex.test(mailInput.value)) {
        mailInput.classList.remove("border-gray-700");
        mailInput.classList.add("border-red-500");
        mailError.classList.remove("hidden");
    } else {
        mailInput.classList.remove("border-red-500");
        mailInput.classList.add("border-green-500");
        mailError.classList.add("hidden");
    }
});

submitBtn.addEventListener("click", () => {

    const isimValid = /^[A-Za-zğüşöçıİĞÜŞÖÇ\s]+$/.test(isimInput.value);
    const telefonValid = /^[0-9]{10,11}$/.test(telefonInput.value);
    const mailValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(mailInput.value);

    if (isimValid && telefonValid && mailValid) {

        toast.classList.remove("hidden");
        toast.classList.remove("bg-red-600");
        toast.classList.add("bg-green-600");
        toast.innerText = "Başarıyla gönderildi ✅\nYetkilimiz sizinle en kısa sürede görüşecektir.";

    } else {

        toast.classList.remove("hidden");
        toast.classList.remove("bg-green-600");
        toast.classList.add("bg-red-600");
        toast.innerText = "Gönderim işlemi başarısız ❌";

    }

    // Kaybolma
    setTimeout(() => {
        toast.classList.add("hidden");
    }, 3000);

});
</script>

</body>
</html>