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
                        name="isim"
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Adınız Soyadınız">
                </div>

                <!-- Mail -->
                <div>
                    <label class="block mb-2 font-semibold">
                        Mail Adresi
                    </label>
                    <input type="email"
                        name="mail"
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="ornek@mail.com">
                </div>

                <!-- Telefon -->
                <div>
                    <label class="block mb-2 font-semibold">
                        Telefon Numarası
                    </label>
                    <input type="tel"
                        name="telefon"
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="05xx xxx xx xx">
                </div>

                <!-- Buton -->
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Gönder
                </button>

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

</body>
</html>