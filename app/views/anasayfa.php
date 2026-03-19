<?php
include("baglan.php");
?>

<!DOCTYPE html>
<html lang="en">
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
}

.logo{
font-size:28px;
font-weight:700;
color:#ff2a2a;
}

.menu{
display:flex;
gap:35px;
}

.menu a{
color:#ddd;
text-decoration:none;
font-weight:500;
transition:.3s;
}

.menu a:hover{
color:#ff2a2a;
}

.auth{
display:flex;
gap:12px;
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
font-size:48px;
margin-bottom:20px;
letter-spacing:2px;
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

/* Bölüm */

.section{
padding:60px 80px;
}

.section-title{
font-size:26px;
font-weight:600;
margin-bottom:30px;
}

/* Film Tablosu */

.movies{
display:grid;
grid-template-columns:repeat(auto-fill,minmax(210px,1fr));
gap:25px;
}

/* Film Kartı */

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

.movie-body{
padding:15px;
}

.movie-title{
font-weight:600;
margin-bottom:8px;
}

.rating{
color:#ffc107;
font-size:14px;
margin-bottom:12px;
}

.buy{
width:100%;
padding:9px;
background:#ff2a2a;
border:none;
color:white;
border-radius:6px;
cursor:pointer;
transition:.3s;
}

.buy:hover{
background:#e02121;
}

/* Daha Fazla */

.more{
margin-top:40px;
text-align:center;
}

.more button{
padding:12px 25px;
border:none;
background:#2a2a2a;
color:white;
border-radius:6px;
cursor:pointer;
}

    .kategoriSlider{
display:flex;
gap:20px;
overflow-x:auto;
padding-bottom:10px;
}

.kategoriSlider::-webkit-scrollbar{
height:8px;
}

.kategoriSlider::-webkit-scrollbar-thumb{
background:#444;
border-radius:10px;
}

</style>
</head>


<body>

<!-- Sol Üst -->

<div class="navbar">

<div class="logo">CineDavud</div>

<div class="menu">
<a href="#filmler">Filmler</a>
<a href="#yakinda">Yakında</a>
<a href="hakkımızda.php">Hakkımızda&İletişim</a>
<a href="#tumunuGor">Daha Fazla</a>
</div>

<div class="auth">
<a href="giris.php">
<button class="btn login">Giriş Yap</button>
</a>
<a href="uyeol.php">
<button class="btn signup">Üye Ol</button>
</a>
</div>

</div>


<!-- Orta Kısım -->

<div class="hero">

<div class="hero-content">
<h1>BİLETİNİZİ ALIN</h1>
<button class="buy" onclick="window.location.href='biletal.php'">Bilet Al</button>
</div>

</div>


<!-- VIZYON -->

<div class="section" id="filmler">

<div class="section-title">Vizyondaki Filmler</div>

<div class="movies" id="filmListesi">

<div class="movie">
<?php

$sql = "SELECT * FROM filmler";
$sonuc = $baglan->query($sql);

while($row = $sonuc->fetch_assoc()){
?>

<div class="movie">
<img src="<?php echo $row["resim"]; ?>">

<div class="movie-body">
<div class="movie-title">
<?php echo $row["film_adi"]; ?>
</div>

<button class="buy">Bilet Al</button>
</div>
</div>

<?php } ?>

</div>

</div>


<!-- YAKINDA -->

<div class="section" id="yakinda">

<div class="section-title">Yakında</div>

<div class="movies">

<div class="movie">
<img src="https://picsum.photos/400/600?5">
<div class="movie-body">
<div class="movie-title">Uzay Macerası</div>
</div>
</div>

<div class="movie">
<img src="https://picsum.photos/400/600?6">
<div class="movie-body">
<div class="movie-title">Tarihin İzleri</div>
</div>
</div>

<div class="movie">
<img src="https://picsum.photos/400/600?7">
<div class="movie-body">
<div class="movie-title">Süper Kahraman</div>
</div>
</div>

<div class="movie">
<img src="https://picsum.photos/400/600?8">
<div class="movie-body">
<div class="movie-title">Romantik Anlar</div>
</div>
</div>

</div>
<div class="section" id="tumunuGor">
<div class="more">
<button id="tumunuGorBtn">Tümünü Gör</button>
</div>

</div>

    <script>

const btn = document.getElementById("tumunuGorBtn");
const filmBolumu = document.getElementById("filmler");

btn.addEventListener("click", () => {

const yeniKategori = `
<h2 style="margin-top:60px;margin-bottom:20px;">Aksiyon Filmleri</h2>

<div class="kategoriSlider">

<div class="movie">
<img src="https://picsum.photos/400/600?1">
<div class="movie-body">
<div class="movie-title">Hızlı Operasyon</div>
<button class="buy">Bilet Al</button>
</div>
</div>

<div class="movie">
<img src="https://picsum.photos/400/600?2">
<div class="movie-body">
<div class="movie-title">Tehlikeli Görev</div>
<button class="buy">Bilet Al</button>
</div>
</div>

<div class="movie">
<img src="https://picsum.photos/400/600?3">
<div class="movie-body">
<div class="movie-title">Gece Takibi</div>
<button class="buy">Bilet Al</button>
</div>
</div>

<div class="movie">
<img src="https://picsum.photos/400/600?4">
<div class="movie-body">
<div class="movie-title">Son Çarpışma</div>
<button class="buy">Bilet Al</button>
</div>
</div>

<div class="movie">
<img src="https://picsum.photos/400/600?5">
<div class="movie-body">
<div class="movie-title">Büyük Operasyon</div>
<button class="buy">Bilet Al</button>
</div>
</div>

</div>
`;

filmBolumu.innerHTML += yeniKategori;

btn.remove(); // butonu siler

});

</script>

</body>
</html>