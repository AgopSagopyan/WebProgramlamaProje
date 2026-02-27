<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="./output.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">

  
    <header class="relative w-full h-[450px] overflow-hidden mb-12">
    <div class="absolute inset-0 w-full h-full">
        <img src="../img/sinema.png" 
             alt="Header Background" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/50"></div>
    </div>


    <div class="relative z-10 flex flex-col h-full">
        
        <nav class="flex justify-between items-center px-8 py-6">
            <h1 class="text-2xl font-extrabold text-white tracking-tight italic">
                DAVUT<span class="text-blue-500 underline">SİNEMALARI</span>
            </h1>

            <div class="hidden md:flex space-x-8">
                <a href="#ana-sayfa" class="text-white hover:text-blue-400 font-semibold transition duration-300">Ana Sayfa</a>
                <a href="#filmler" class="text-white hover:text-blue-400 font-semibold transition duration-300">Yerli</a>
                <a href="yabancı.php" class="hover:text-blue-300 text-white">
                        Yabancı
                 </a>
                <a href="hakkımızda.php" class="hover:text-blue-300 text-white">
                    Hakkımızda & İletişim
                </a>
            </div>

            <button id= "menuBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-medium transition shadow-lg">
                Menü
            </button>
        </nav>

        <!-- Menü paneli -->
<div id="sideMenu"
     class="fixed top-0 right-0 h-full w-80 bg-white shadow-lg transform translate-x-full transition-transform duration-300 z-50 overflow-y-auto">

    <div class="p-6">

        <!-- Kapat Butonu -->
        <button id="closeBtn"
            class="text-xl font-bold mb-6">
            ✕ Kapat
        </button>

        <!-- Film -->
        <div class="mb-4">
            <button id="filmBtn"
                class="w-full text-left font-semibold text-lg">
                Filmler
            </button>
            <div id="filmMenu" class="hidden mt-2 ml-4 space-y-2 text-sm text-gray-600">
                <div>Aksiyon</div>
                <div>Komedi</div>
                <div>Dram</div>
            </div>
        </div>

        <!-- Bowling -->
        <div class="mb-4">
            <button id="bowlingBtn"
                class="w-full text-left font-semibold text-lg">
                Bowling
            </button>
            <div id="bowlingMenu" class="hidden mt-2 ml-4 space-y-2 text-sm text-gray-600">
                <div>Saat 14:00</div>
                <div>Saat 16:00</div>
            </div>
        </div>

        <!-- Konser -->
        <div class="mb-4">
            <button id="konserBtn"
                class="w-full text-left font-semibold text-lg">
                Konser
            </button>
            <div id="konserMenu" class="hidden mt-2 ml-4 space-y-2 text-sm text-gray-600">
                <div>Pop</div>
                <div>Rock</div>
            </div>
        </div>

    </div>
</div>

        <script>
    const menuBtn = document.getElementById("menuBtn");
    const sideMenu = document.getElementById("sideMenu");
    const closeBtn = document.getElementById("closeBtn");

    const filmBtn = document.getElementById("filmBtn");
    const filmMenu = document.getElementById("filmMenu");

    const bowlingBtn = document.getElementById("bowlingBtn");
    const bowlingMenu = document.getElementById("bowlingMenu");

    const konserBtn = document.getElementById("konserBtn");
    const konserMenu = document.getElementById("konserMenu");

    // Menü Aç
    menuBtn.addEventListener("click", () => {
        sideMenu.classList.remove("translate-x-full");
    });

    // Menü Kapat
    closeBtn.addEventListener("click", () => {
        sideMenu.classList.add("translate-x-full");
    });

    // Alt Menüler
    filmBtn.addEventListener("click", () => {
        filmMenu.classList.toggle("hidden");
    });

    bowlingBtn.addEventListener("click", () => {
        bowlingMenu.classList.toggle("hidden");
    });

    konserBtn.addEventListener("click", () => {
        konserMenu.classList.toggle("hidden");
    });
</script>

        <div class="flex-grow flex flex-col justify-center items-center text-center px-4">
            <h2 class="text-white text-4xl md:text-5xl font-bold mb-2 drop-shadow-md">
                Eğlenceye Bir Adım Kaldı
            </h2>
            <p class="text-gray-300 text-lg max-w-xl">
                Şehrindeki en iyi etkinlikleri keşfet ve yerini anında ayırt.
            </p>
        </div>

    </div>
</header>

    <div class="flex gap-6 justify-start">

        <!-- Kart -->
    <div class="w-96 bg-white rounded-lg shadow-lg overflow-hidden">

        <!-- Fotoğraf -->
        <img src="../img/maymun.png"
             alt="Film Resmi"
             class="w-full h-80 object-cover">

        <!-- Çerçeve -->
        <div class="p-6 border-t border-gray-200">

            <!-- Film İsmi -->
            <h2 class="text-2xl font-bold text-gray-800">Davut Ve En İyi Arkadaşı</h2>

            <!-- Küçük Açıklama -->
            <p class="text-sm text-gray-500 mt-2">Komedi • 90 Dakika • 2026</p>

            <!-- Rezervasyon Butonu -->
            <button class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-3 rounded-lg w-full">
                Rezervasyon Yap
            </button>

        </div>

    </div>

    <div class="w-96 bg-white rounded-lg shadow-lg overflow-hidden flex-shrink-0">
            <img src="../img/images.png"
                 alt="Film Resmi"
                 class="w-full h-80 object-cover">
            <div class="p-6 border-t border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">Five Nights At Davut's</h2>
                <p class="text-sm text-gray-500 mt-2">Korku • 120 Dakika • 2025</p>
                <button class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-3 rounded-lg w-full">
                    Rezervasyon Yap
                </button>
            </div>
        </div>

    </div>


    
</body>
</html>