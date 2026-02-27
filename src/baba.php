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
                <a href="#filmler" class="text-white hover:text-blue-400 font-semibold transition duration-300">Filmler</a>
                <a href="#etkinlikler" class="text-white hover:text-blue-400 font-semibold transition duration-300">Etkinlikler</a>
                <a href="#hakkimizda" class="text-white hover:text-blue-400 font-semibold transition duration-300">Hakkımızda</a>
                <a href="#iletisim" class="text-white hover:text-blue-400 font-semibold transition duration-300">İletişim</a>
            </div>

            <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-medium transition shadow-lg">
                Üye Ol
            </button>
        </nav>

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
                <h2 class="text-2xl font-bold text-gray-800">
                    <?php
                            require_once "database.php";  
                            
                            $sql = "SELECT movieName FROM Film";
                            $stmt = $pdo->query($sql);
                            
                            while($row = $stmt->fetch()) {
                                echo $row['movieName'];
                            }

                    ?>
                </h2>
                <p class="text-sm text-gray-500 mt-2">Korku • 120 Dakika • 2025</p>
                <button class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-3 rounded-lg w-full">
                    Rezervasyon Yap
                </button>
            </div>
        </div>

    </div>


    
</body>
</html>
