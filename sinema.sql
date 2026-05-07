-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 07 May 2026, 20:53:04
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `sinema`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `adminler`
--

CREATE TABLE `adminler` (
  `id` int(11) NOT NULL,
  `kullanici` varchar(50) DEFAULT NULL,
  `sifre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `adminler`
--

INSERT INTO `adminler` (`id`, `kullanici`, `sifre`) VALUES
(1, 'admin', '1234');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `biletler`
--

CREATE TABLE `biletler` (
  `id` int(11) NOT NULL,
  `film_id` int(11) NOT NULL,
  `konum` varchar(100) NOT NULL,
  `seans` varchar(50) NOT NULL,
  `koltuklar` varchar(255) NOT NULL,
  `isim` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `adet` int(11) NOT NULL DEFAULT 1,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `biletler`
--

INSERT INTO `biletler` (`id`, `film_id`, `konum`, `seans`, `koltuklar`, `isim`, `email`, `adet`, `tarih`) VALUES
(21, 63, 'Salon 1', '13:00', 'A4', 'emirbnabu', 'emir@gmailc.om', 1, '2026-05-07 18:34:37');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `filmler`
--

CREATE TABLE `filmler` (
  `id` int(11) NOT NULL,
  `film_adi` varchar(255) DEFAULT NULL,
  `resim` varchar(255) DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `aciklama` text DEFAULT NULL,
  `fiyat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `filmler`
--

INSERT INTO `filmler` (`id`, `film_adi`, `resim`, `kategori`, `aciklama`, `fiyat`) VALUES
(63, 'davudimagmedi', 'uploads/1778178085_ChatGPT Image 26 Nis 2026 15_10_03.png', 'Aksiyon', 'bay davudimagmedinin hayat hikayesini anlatan bu film 2saat 15dakika sürmektedir', 150),
(65, 'davudimagmedi', 'uploads/1778178283_Gemini_Generated_Image_paxq5gpaxq5gpaxq.png', 'Korku', 'ababaibiabi', 5000);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategoriler`
--

CREATE TABLE `kategoriler` (
  `id` int(11) NOT NULL,
  `kategori_adi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `id` int(11) NOT NULL,
  `isim` varchar(100) DEFAULT NULL,
  `mail` varchar(100) DEFAULT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `sifre` varchar(255) DEFAULT NULL,
  `kayit_tarihi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`id`, `isim`, `mail`, `telefon`, `sifre`, `kayit_tarihi`) VALUES
(4, 'emirbnabu', 'emir@gmailc.om', '4153241248', '123', '2026-03-19 00:19:34'),
(7, 'emirbab', 'emir@gmail.o', '12412415512', '12', '2026-03-19 00:25:46'),
(12, 'ababz', 'emir@gmailc.oma', '4153241248', '513', '2026-04-13 17:31:06'),
(13, 'babu', 'babu@mail.com', '4153241248', '123', '2026-05-07 18:30:27');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sikayetler`
--

CREATE TABLE `sikayetler` (
  `id` int(11) NOT NULL,
  `isim` varchar(100) DEFAULT NULL,
  `mesaj` text DEFAULT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp(),
  `okundu` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `sikayetler`
--

INSERT INTO `sikayetler` (`id`, `isim`, `mesaj`, `tarih`, `okundu`) VALUES
(3, 'emir babu', 'bu nası site ıy ıyy', '2026-05-05 14:35:16', 1);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `adminler`
--
ALTER TABLE `adminler`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kullanici` (`kullanici`);

--
-- Tablo için indeksler `biletler`
--
ALTER TABLE `biletler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `film_id` (`film_id`);

--
-- Tablo için indeksler `filmler`
--
ALTER TABLE `filmler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kategoriler`
--
ALTER TABLE `kategoriler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- Tablo için indeksler `sikayetler`
--
ALTER TABLE `sikayetler`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `adminler`
--
ALTER TABLE `adminler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `biletler`
--
ALTER TABLE `biletler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Tablo için AUTO_INCREMENT değeri `filmler`
--
ALTER TABLE `filmler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Tablo için AUTO_INCREMENT değeri `kategoriler`
--
ALTER TABLE `kategoriler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Tablo için AUTO_INCREMENT değeri `sikayetler`
--
ALTER TABLE `sikayetler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `biletler`
--
ALTER TABLE `biletler`
  ADD CONSTRAINT `biletler_ibfk_1` FOREIGN KEY (`film_id`) REFERENCES `filmler` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
