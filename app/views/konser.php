<?php
// PHP session ve veritabanı bağlantıları
// session_start();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SeatVision | Sagopa Kajmer Canlı!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        brand: { 50: '#eff6ff', 100: '#dbeafe', 500: '#3b82f6', 600: '#2563eb', 900: '#1e3a8a' },
                        alert: '#ef4444'
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #f8fafc; color: #0f172a; overflow-x: hidden; }
        
        /* Hype Animasyonları */
        .hype-text { opacity: 0; transform: scale(0.95); filter: blur(4px); pointer-events: none; }
        .hype-active { 
            animation: cinematicFade 2.5s ease-out forwards; 
        }
        @keyframes cinematicFade {
            0% { opacity: 0; transform: scale(0.95); filter: blur(4px); letter-spacing: normal; }
            30% { opacity: 1; transform: scale(1); filter: blur(0px); }
            80% { opacity: 1; transform: scale(1.05); filter: blur(0px); letter-spacing: 0.1em; }
            100% { opacity: 0; transform: scale(1.1); filter: blur(4px); letter-spacing: 0.2em; }
        }

        .glitch-flash {
            animation: flashOverlay 0.5s ease-out forwards;
        }
        @keyframes flashOverlay {
            0% { background-color: #fff; opacity: 1; }
            100% { background-color: transparent; opacity: 0; visibility: hidden; }
        }

        .hero-mask {
            background: linear-gradient(to bottom, rgba(15,23,42,0.8) 0%, rgba(15,23,42,0.2) 50%, #f8fafc 100%);
        }
    </style>
</head>
<body class="antialiased">

    <!-- ARKA PLAN MÜZİĞİ -->
    <!-- 'sagopa_beat.mp3' yerine kendi dosyanın adını yazmalısın -->
    <audio id="bg-music" loop preload="auto">
        <source src="sagopa_beat.mp3" type="audio/mpeg">
    </audio>

    <!-- SİNEMATİK GİRİŞ (HYPE INTRO) -->
    <div id="intro-screen" class="fixed inset-0 z-[100] bg-black flex flex-col items-center justify-center transition-opacity duration-700">
        
        <!-- BAŞLAT BUTONU (Tarayıcı ses onayı için zorunlu) -->
        <div id="start-container" class="absolute inset-0 flex flex-col items-center justify-center z-50 bg-black transition-opacity duration-500">
            <button id="start-btn" class="group relative px-8 py-4 bg-transparent border border-white/20 hover:border-white/60 text-white rounded-full uppercase tracking-widest text-sm font-bold transition-all hover:scale-105 overflow-hidden">
                <div class="absolute inset-0 bg-white/10 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                <span class="relative flex items-center gap-3">
                    Deneyimi Başlat <i class="fa-solid fa-headphones text-brand-500 group-hover:animate-bounce"></i>
                </span>
            </button>
            <p class="text-white/40 text-xs mt-4 font-mono tracking-widest uppercase">Lütfen sesin açık olduğundan emin olun</p>
        </div>

        <!-- Metin 1 -->
        <div id="text-1" class="absolute hype-text text-white font-bold text-2xl md:text-5xl uppercase tracking-widest text-center px-4">
            Bu Etkinliğe<br><span class="text-brand-500 text-lg md:text-3xl mt-2 block">Hazır mısın?</span>
        </div>
        <!-- Metin 2 -->
        <div id="text-2" class="absolute hype-text text-white font-black text-5xl md:text-8xl uppercase text-center px-4 mix-blend-difference">
            SAGOPA<br>KAJMER
        </div>
        <!-- Metin 3 -->
        <div id="text-3" class="absolute hype-text text-alert font-black text-4xl md:text-6xl uppercase tracking-[0.3em] text-center px-4">
            CANLI.
        </div>
        
        <!-- Patlama Efekti İçin Beyaz Flaş -->
        <div id="flash-overlay" class="absolute inset-0 bg-white opacity-0 hidden z-50 pointer-events-none"></div>
    </div>

    <!-- NAVBAR -->
    <nav class="absolute w-full z-40 top-0 border-b border-white/10 bg-transparent text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="index.php" class="text-2xl font-black tracking-tighter uppercase">
                Seat<span class="text-brand-500">Vision</span>
            </a>
            <div class="hidden md:flex gap-8 text-sm font-medium">
                <a href="#" class="hover:text-brand-500 transition-colors">Konserler</a>
                <a href="#" class="hover:text-brand-500 transition-colors">Festivaller</a>
                <a href="#" class="text-alert flex items-center gap-1"><i class="fa-solid fa-bolt"></i> Flaş İndirimler</a>
            </div>
            <div class="flex items-center gap-4">
                <a href="#" class="text-sm font-medium hover:text-brand-500">Giriş Yap</a>
                <a href="#" class="bg-white text-black hover:bg-brand-500 hover:text-white text-sm font-bold px-5 py-2.5 rounded-full transition-all">Kayıt Ol</a>
            </div>
        </div>
    </nav>

    <!-- SİNEMATİK HERO (SAGOPA KAJMER ÖZEL) -->
    <section class="relative h-screen min-h-[600px] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Sagopa Concert" class="w-full h-full object-cover object-top filter brightness-50">
            <div class="absolute inset-0 hero-mask"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full text-center mt-20">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-alert/20 border border-alert/50 text-alert text-xs font-bold uppercase tracking-widest mb-6 backdrop-blur-sm">
                <span class="w-2 h-2 rounded-full bg-alert animate-pulse"></span> Yılın En Büyük Konseri
            </div>
            <h1 class="text-6xl md:text-8xl lg:text-9xl font-black text-white uppercase tracking-tighter leading-none mb-6 drop-shadow-2xl">
                Sagopa<br><span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-white">Kajmer</span>
            </h1>
            <div class="flex flex-col md:flex-row items-center justify-center gap-4 md:gap-8 text-white/80 font-medium text-lg mb-10">
                <span class="flex items-center gap-2"><i class="fa-regular fa-calendar text-brand-500"></i> 18 Ağustos 2026</span>
                <span class="hidden md:block w-1 h-1 bg-white/30 rounded-full"></span>
                <span class="flex items-center gap-2"><i class="fa-solid fa-location-dot text-brand-500"></i> Beşiktaş Tüpraş Stadyumu</span>
            </div>
            
            <a href="checkout.php" class="inline-flex items-center gap-2 bg-brand-600 text-white font-bold text-lg px-10 py-4 rounded-full hover:bg-brand-500 hover:scale-105 transition-all shadow-[0_0_40px_rgba(37,99,235,0.4)]">
                Biletini Garantile <i class="fa-solid fa-arrow-right"></i>
            </a>
            
            <p class="text-white/50 text-sm mt-6 font-medium">Akıllı grup rezervasyonu ile arkadaşlarınla yan yana izle.</p>
            
            <!-- Müzik Kontrol Butonu (Sayfaya geçtikten sonra müziği kapatabilmesi için) -->
            <button id="mute-btn" class="mt-12 text-white/40 hover:text-white transition-colors text-xs border border-white/20 rounded-full px-4 py-2 flex items-center gap-2 mx-auto">
                <i class="fa-solid fa-volume-high" id="mute-icon"></i> Müziği Kapat
            </button>
        </div>
    </section>

    <!-- FLAŞ İNDİRİMLER -->
    <section class="py-16 relative z-20 -mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-alert animate-pulse"></span> Anlık İndirimler
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">Sınırlı süre için özel fiyatlı diğer etkinlikler.</p>
                    </div>
                    <div class="text-sm font-semibold text-alert bg-red-50 px-4 py-2 rounded-lg border border-red-100">
                        Fırsatların Bitmesine: <span id="flash-timer" class="font-mono text-base">02:14:59</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="flex gap-4 p-4 rounded-xl hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                        <img src="https://images.unsplash.com/photo-1514525253161-7a46d19cd819?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" class="w-24 h-24 rounded-lg object-cover" alt="">
                        <div class="flex flex-col justify-between flex-1">
                            <div>
                                <h3 class="font-bold text-gray-900 leading-tight">Cem Adrian Akustik</h3>
                                <p class="text-xs text-gray-500 mt-1"><i class="fa-solid fa-location-dot"></i> Zorlu PSM</p>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-lg font-extrabold text-alert">850 ₺ <span class="text-xs text-gray-400 line-through font-normal">1.200 ₺</span></span>
                            </div>
                        </div>
                    </div>
                    <!-- Diğer kartlar eklenebilir -->
                </div>
            </div>
        </div>
    </section>

    <!-- HYPE ANIMATION & AUDIO LOGIC -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const introScreen = document.getElementById('intro-screen');
            const startContainer = document.getElementById('start-container');
            const startBtn = document.getElementById('start-btn');
            
            const text1 = document.getElementById('text-1');
            const text2 = document.getElementById('text-2');
            const text3 = document.getElementById('text-3');
            const flashOverlay = document.getElementById('flash-overlay');
            
            const bgMusic = document.getElementById('bg-music');
            const muteBtn = document.getElementById('mute-btn');
            const muteIcon = document.getElementById('mute-icon');

            document.body.style.overflow = 'hidden'; // Kaydırmayı kitle

            // 1. KULLANICI BAŞLAT BUTONUNA TIKLADIĞINDA
            startBtn.addEventListener('click', () => {
                // Müziği Başlat
                bgMusic.volume = 0.6; // Sesi çok patlamaması için biraz kıstık
                bgMusic.play().catch(e => console.log("Müzik başlatılamadı:", e));

                // Başlat ekranını yavaşça yok et
                startContainer.style.opacity = '0';
                setTimeout(() => startContainer.remove(), 500);

                // 2. ANİMASYON SEKANSINI BAŞLAT
                setTimeout(() => { text1.classList.add('hype-active'); }, 500);
                setTimeout(() => { text2.classList.add('hype-active'); }, 3000);
                setTimeout(() => { text3.classList.add('hype-active'); }, 5500);

                // 3. PATLAMA VE SİTEYE GEÇİŞ
                setTimeout(() => {
                    flashOverlay.classList.remove('hidden');
                    flashOverlay.classList.add('glitch-flash');
                    
                    introScreen.style.opacity = '0';
                    
                    setTimeout(() => {
                        introScreen.remove();
                        document.body.style.overflow = ''; // Scroll kilidini aç
                        document.body.style.overflowX = 'hidden';
                    }, 500);
                }, 7800);
            });

            // Sesi Aç/Kapat Butonu İşlevi (Ana sayfaya geçtikten sonra)
            muteBtn.addEventListener('click', () => {
                if (bgMusic.muted) {
                    bgMusic.muted = false;
                    muteIcon.classList.replace('fa-volume-xmark', 'fa-volume-high');
                    muteBtn.innerHTML = `<i class="fa-solid fa-volume-high" id="mute-icon"></i> Müziği Kapat`;
                } else {
                    bgMusic.muted = true;
                    muteIcon.classList.replace('fa-volume-high', 'fa-volume-xmark');
                    muteBtn.innerHTML = `<i class="fa-solid fa-volume-xmark" id="mute-icon"></i> Sesi Aç`;
                }
            });

            // Geri Sayım Sayacı
            let time = 2 * 3600 + 14 * 60 + 59; 
            setInterval(() => {
                time--;
                let h = Math.floor(time / 3600);
                let m = Math.floor((time % 3600) / 60);
                let s = time % 60;
                document.getElementById('flash-timer').innerText = 
                    (h < 10 ? "0"+h : h) + ":" + (m < 10 ? "0"+m : m) + ":" + (s < 10 ? "0"+s : s);
            }, 1000);
        });
    </script>
</body>
</html>