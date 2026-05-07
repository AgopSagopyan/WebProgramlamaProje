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

html{
scroll-behavior:smooth;
}

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:#0e0e0e;
color:white;
}

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

.logo{
font-size:28px;
font-weight:700;
color:#ff2a2a;
}

.menu{
display:flex;
gap:25px;
}

.menu a{
color:#bbb;
text-decoration:none;
font-weight:500;
transition:.3s;
padding-bottom:3px;
}

.menu a:hover{
color:#ff2a2a;
}

.menu a.active{
color:#ff2a2a;
border-bottom:2px solid #ff2a2a;
}

/* AUTH */
.auth{
display:flex;
gap:12px;
align-items:center;
}

.btn{
padding:8px 18px;
border:none;
cursor:pointer;
border-radius:6px;
font-weight:500;
}

.login{
background:#2b2b2b;
color:white;
}

.signup{
background:#ff2a2a;
color:white;
}

/* DROPDOWN */
.dropdown{
position:relative;
}

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
overflow:hidden;
}

.dropdown-menu a{
padding:12px;
text-decoration:none;
color:white;
border-bottom:1px solid #333;
}

.dropdown-menu a:last-child{
border-bottom:none;
color:#ff4d4d;
}

.dropdown-menu a:hover{
background:#2b2b2b;
}

.show{
display:flex;
}

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

.hero-content{
position:relative;
z-index:2;
}

.hero h1{
font-size:52px;
margin-bottom:20px;
}

.hero button{
background:#ff2a2a;
border:none;
padding:15px 40px;
font-size:18px;
border-radius:8px;
cursor:pointer;
transition:.3s;
}

.hero button:hover{
background:#e02121;
}

/* FİLMLER */
.section{
padding:60px 80px;
}

.section-title{
font-size:30px;
font-weight:700;
margin-bottom:30px;
}

.movies{
display:grid;
grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
gap:30px;
}

.movie{
background:#1a1a1a;
border-radius:14px;
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
height:320px;
object-fit:cover;
}

.movie-body{
padding:15px;
}

.movie-title{
font-size:18px;
font-weight:600;
margin-bottom:10px;
}

.movie-price{
color:#ff2a2a;
font-weight:600;
margin-bottom:12px;
}

.buy{
width:100%;
padding:10px;
background:#ff2a2a;
border:none;
color:white;
border-radius:6px;
cursor:pointer;
font-size:15px;
transition:.3s;
}

.buy:hover{
background:#e02121;
}

/* MODAL */
.modal{
position:fixed;
inset:0;
background:rgba(0,0,0,.8);
display:none;
justify-content:center;
align-items:center;
z-index:99999;
padding:20px;
}

.modal-content{
background:#1a1a1a;
width:100%;
max-width:800px;
border-radius:16px;
overflow:hidden;
display:flex;
flex-wrap:wrap;
position:relative;
animation:modalOpen .3s ease;
}

@keyframes modalOpen{
from{
transform:scale(.8);
opacity:0;
}
to{
transform:scale(1);
opacity:1;
}
}

.modal-left{
flex:1;
min-width:300px;
}

.modal-left img{
width:100%;
height:100%;
object-fit:cover;
}

.modal-right{
flex:1;
padding:30px;
display:flex;
flex-direction:column;
justify-content:center;
}

.modal-title{
font-size:32px;
font-weight:700;
margin-bottom:15px;
}

.modal-category{
color:#999;
margin-bottom:20px;
}

.modal-desc{
line-height:1.7;
color:#ddd;
margin-bottom:25px;
}

.modal-price{
font-size:24px;
font-weight:700;
color:#ff2a2a;
margin-bottom:25px;
}

.modal-buy{
background:#ff2a2a;
padding:14px;
border:none;
border-radius:8px;
font-size:17px;
cursor:pointer;
color:white;
transition:.3s;
}

.modal-buy:hover{
background:#e02121;
}

.close{
position:absolute;
top:15px;
right:20px;
font-size:28px;
cursor:pointer;
color:white;
}

/* RESPONSIVE */
@media(max-width:768px){

.navbar{
padding:20px;
flex-direction:column;
gap:20px;
}

.section{
padding:40px 20px;
}

.modal-content{
flex-direction:column;
}

.hero h1{
font-size:38px;
}

}
</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">

<div class="logo">
CineDavud
</div>

<div class="menu">

<?php
$menuKategoriler = $baglan->query("SELECT DISTINCT kategori FROM filmler");

while($mk = $menuKategoriler->fetch_assoc()){

$id = strtolower(str_replace(" ","-",$mk["kategori"]));
?>

<a href="#<?= $id ?>" class="menu-link">
<?= $mk["kategori"] ?>
</a>

<?php } ?>

<a href="iletisim.php">
İletişim
</a>

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

<a href="giris.php">
<button class="btn login">Giriş Yap</button>
</a>

<a href="uyeol.php">
<button class="btn signup">Üye Ol</button>
</a>

<?php } ?>

</div>

</div>

<!-- HERO -->
<div class="hero">

<div class="hero-content">

<h1>
BİLETİNİZİ ALIN
</h1>

<button onclick="window.location.href='biletal.php'">
Bilet Al
</button>

</div>

</div>

<!-- FİLMLER -->
<div class="section" id="filmler">

<?php
$kategoriler = $baglan->query("SELECT DISTINCT kategori FROM filmler");

while($kat = $kategoriler->fetch_assoc()){

$kat_id = strtolower(str_replace(" ","-",$kat["kategori"]));
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

<div class="movie-title">
<?= $film["film_adi"] ?>
</div>

<div class="movie-price">
<?= $film["fiyat"] ?> ₺
</div>

<button class="buy"
onclick='openModal(
"<?= addslashes($film["film_adi"]) ?>",
"<?= addslashes($film["kategori"]) ?>",
"<?= addslashes($film["aciklama"]) ?>",
"<?= $film["resim"] ?>",
"<?= $film["fiyat"] ?>",
"<?= $film["id"] ?>"
)'>
İncele
</button>

</div>

</div>

<?php } ?>

</div>

<?php } ?>

</div>

<!-- MODAL -->
<div class="modal" id="filmModal">

<div class="modal-content">

<div class="close" onclick="closeModal()">
✖
</div>

<div class="modal-left">
<img id="modalImage">
</div>

<div class="modal-right">

<div class="modal-title" id="modalTitle"></div>

<div class="modal-category" id="modalCategory"></div>

<div class="modal-desc" id="modalDesc"></div>

<div class="modal-price" id="modalPrice"></div>

<button class="modal-buy" id="modalButton">
Bilet Al
</button>

</div>

</div>

</div>

<script>

function toggleMenu(){
document.getElementById("dropdownMenu").classList.toggle("show");
}

window.onclick = function(e){

if(!e.target.closest('.dropdown')){
document.getElementById("dropdownMenu").classList.remove("show");
}

if(e.target == document.getElementById("filmModal")){
closeModal();
}

}

function openModal(ad,kategori,aciklama,resim,fiyat,id){

document.getElementById("filmModal").style.display="flex";

document.getElementById("modalTitle").innerText = ad;
document.getElementById("modalCategory").innerText = kategori;
document.getElementById("modalDesc").innerText = aciklama;
document.getElementById("modalImage").src = resim;
document.getElementById("modalPrice").innerText = fiyat + " ₺";

document.getElementById("modalButton").onclick = function(){
window.location.href = "biletal.php?film_id=" + id;
}

}

function closeModal(){
document.getElementById("filmModal").style.display="none";
}

/* AKTİF KATEGORİ */
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