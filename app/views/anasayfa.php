<?php
session_start();
include("baglan.php");

/* COOKIE → SESSION */
if(!isset($_SESSION['kullanici_id']) && isset($_COOKIE['kullanici_id'])){
    $_SESSION['kullanici_id'] = $_COOKIE['kullanici_id'];
    $_SESSION['kullanici_isim'] = $_COOKIE['kullanici_isim'];
    $_SESSION['kullanici_email'] = $_COOKIE['kullanici_email'];
}

/* KATEGORİLER */
$kategoriler = $baglan->query("SELECT DISTINCT kategori FROM filmler");
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>CinemaWorld</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
html{scroll-behavior:smooth;}
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{background:#0e0e0e;color:white;}

/* NAVBAR */
.navbar{
display:flex;
justify-content:space-between;
align-items:center;
padding:20px 70px;
background:#121212;
border-bottom:1px solid #222;
position:sticky;
top:0;
z-index:999;
}

.logo{font-size:28px;font-weight:700;color:#ff2a2a;}

.menu{display:flex;gap:25px;}

.menu a{
color:#bbb;
text-decoration:none;
font-weight:500;
transition:.3s;
padding-bottom:3px;
}

.menu a:hover{color:#ff2a2a;}

/* AKTİF KATEGORİ */
.menu a.active{
color:#ff2a2a;
border-bottom:2px solid #ff2a2a;
}

/* AUTH */
.auth{display:flex;gap:12px;align-items:center;}

.btn{
padding:8px 18px;
border:none;
cursor:pointer;
border-radius:6px;
font-weight:500;
}

.login{background:#2b2b2b;color:white;}
.signup{background:#ff2a2a;color:white;}

/* DROPDOWN */
.dropdown{position:relative;}

.dropdown-btn{
background:#2b2b2b;
padding:8px 18px;
border-radius:6px;
cursor:pointer;
}

.dropdown-menu{
position:absolute;
right:0;
top:45px;
background:#1a1a1a;
border:1px solid #333;
border-radius:8px;
width:180px;
display:none;
flex-direction:column;
z-index:9999;
}

.dropdown-menu a{
padding:12px;
text-decoration:none;
color:white;
border-bottom:1px solid #333;
}

.dropdown-menu a:last-child{border-bottom:none;color:#ff4d4d;}
.dropdown-menu a:hover{background:#2b2b2b;}

.show{display:flex;}

/* HERO */
.hero{
height:500px;
background:url("https://images.unsplash.com/photo-1489599849927-2ee91cede3ba") center/cover;
display:flex;
align-items:center;
justify-content:center;
flex-direction:column;
text-align:center;
position:relative;
}

.hero::after{
content:"";
position:absolute;
inset:0;
background:linear-gradient(to bottom,rgba(0,0,0,.2),#0e0e0e);
}

.hero-content{position:relative;z-index:2;}

.hero h1{font-size:48px;margin-bottom:20px;}

.hero button{
background:#ff2a2a;
border:none;
padding:15px 40px;
font-size:18px;
border-radius:8px;
cursor:pointer;
}

/* FİLMLER */
.section{padding:60px 80px;}

.section-title{
font-size:26px;
font-weight:600;
margin-bottom:25px;
}

.movies{
display:grid;
grid-template-columns:repeat(auto-fill,minmax(210px,1fr));
gap:25px;
}

.movie{
background:#1a1a1a;
border-radius:12px;
overflow:hidden;
transition:.4s;
cursor:pointer;
}

.movie:hover{
transform:translateY(-10px);
box-shadow:0 10px 25px rgba(0,0,0,.6);
}

.movie img{
width:100%;
height:300px;
object-fit:cover;
}

.movie-body{padding:15px;}

.buy{
width:100%;
padding:9px;
background:#ff2a2a;
border:none;
color:white;
border-radius:6px;
cursor:pointer;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">

<div class="logo">CineDavud</div>

<div class="menu" id="menuLinks">

<?php
$menuKategoriler = $baglan->query("SELECT DISTINCT kategori FROM filmler");

while($mk = $menuKategoriler->fetch_assoc()){
$id = strtolower(str_replace(" ", "-", $mk["kategori"]));
?>
<a href="#<?= $id ?>" class="menu-link"><?= $mk["kategori"] ?></a>
<?php } ?>

<a href="iletisim.php">İletişim</a>

</div>

<div class="auth">

<?php if(isset($_SESSION['kullanici_id'])) { ?>

<div class="dropdown">
<div class="dropdown-btn" onclick="toggleMenu()">
👤 <?= $_SESSION['kullanici_isim']; ?>
</div>

<div id="dropdownMenu" class="dropdown-menu">
<a href="biletlerim.php">🎟 Biletlerim</a>
<a href="cikis.php">Çıkış Yap</a>
</div>
</div>

<?php } else { ?>

<a href="giris.php"><button class="btn login">Giriş Yap</button></a>
<a href="uyeol.php"><button class="btn signup">Üye Ol</button></a>

<?php } ?>

</div>

</div>

<!-- HERO -->
<div class="hero">
<div class="hero-content">
<h1>BİLETİNİZİ ALIN</h1>
<button onclick="window.location.href='biletal.php'">Bilet Al</button>
</div>
</div>

<!-- FİLMLER -->
<div class="section" id="filmler">

<?php
$kategoriler = $baglan->query("SELECT DISTINCT kategori FROM filmler");

while($kat = $kategoriler->fetch_assoc()){
$kat_id = strtolower(str_replace(" ", "-", $kat["kategori"]));
?>

<div class="section-title" id="<?= $kat_id ?>">
<?= $kat["kategori"] ?>
</div>

<div class="movies">

<?php
$filmler = $baglan->query("SELECT * FROM filmler WHERE kategori='".$kat["kategori"]."'");

while($film = $filmler->fetch_assoc()){
?>

<div class="movie">
<img src="<?= $film["resim"] ?>">

<div class="movie-body">
<div><?= $film["film_adi"] ?></div>
<button class="buy" onclick="window.location.href='biletal.php'">
Bilet Al
</button>
</div>
</div>

<?php } ?>

</div>

<?php } ?>

</div>

<script>
function toggleMenu(){
document.getElementById("dropdownMenu").classList.toggle("show");
}

window.onclick = function(e){
if(!e.target.closest('.dropdown')){
document.getElementById("dropdownMenu").classList.remove("show");
}
}

/* AKTİF KATEGORİ RENK */
const sections = document.querySelectorAll(".section-title");
const links = document.querySelectorAll(".menu-link");

window.addEventListener("scroll", () => {
let current = "";

sections.forEach(sec => {
const top = window.scrollY;
const offset = sec.offsetTop - 150;
const height = sec.offsetHeight;

if(top >= offset && top < offset + height){
current = sec.getAttribute("id");
}
});

links.forEach(link => {
link.classList.remove("active");
if(link.getAttribute("href") == "#" + current){
link.classList.add("active");
}
});
});
</script>

</body>
</html>