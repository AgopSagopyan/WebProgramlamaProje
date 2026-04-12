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

html{scroll-behavior:smooth;}
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{background:#0e0e0e;color:white;}

/* NAVBAR */
.navbar{display:flex;justify-content:space-between;align-items:center;padding:20px 70px;background:#121212;border-bottom:1px solid #222;}
.logo{font-size:28px;font-weight:700;color:#ff2a2a;}
.menu{display:flex;gap:35px;}
.menu a{color:#ddd;text-decoration:none;font-weight:500;transition:.3s;}
.menu a:hover{color:#ff2a2a;}
.auth{display:flex;gap:12px;}
.btn{padding:8px 18px;border:none;cursor:pointer;border-radius:6px;font-weight:500;}
.login{background:#2b2b2b;color:white;}
.signup{background:#ff2a2a;color:white;}

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
.hero h1{font-size:48px;margin-bottom:20px;letter-spacing:2px;}
.hero button{background:#ff2a2a;border:none;padding:15px 40px;font-size:18px;border-radius:8px;cursor:pointer;}
.hero button:hover{background:#e02121;}

/* SECTION */
.section{padding:60px 80px;}
.section-title{font-size:26px;font-weight:600;margin-bottom:30px;}

/* MOVIES */
.movies{
display:grid;
grid-template-columns:repeat(auto-fill,minmax(210px,1fr));
gap:25px;
}

/* CARD */
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
.movie-title{font-weight:600;margin-bottom:8px;}
.buy{
width:100%;
padding:9px;
background:#ff2a2a;
border:none;
color:white;
border-radius:6px;
cursor:pointer;
}
.buy:hover{background:#e02121;}

</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
<div class="logo">CineDavud</div>

<div class="menu">
<a href="#filmler">Filmler</a>
<a href="hakkımızda.php">Hakkımızda&İletişim</a>
</div>

<div class="auth">
<a href="giris.php"><button class="btn login">Giriş Yap</button></a>
<a href="uyeol.php"><button class="btn signup">Üye Ol</button></a>
</div>
</div>

<!-- HERO -->
<div class="hero">
<div class="hero-content">
<h1>BİLETİNİZİ ALIN</h1>
<button class="buy" onclick="window.location.href='biletal.php'">Bilet Al</button>
</div>
</div>

<!-- FİLMLER -->
<div class="section" id="filmler">
<div class="section-title">Vizyondaki Filmler</div>

<div class="movies">

<?php
$sql = "SELECT * FROM filmler";
$sonuc = $baglan->query($sql);

while($row = $sonuc->fetch_assoc()){
?>

<div class="movie">

<?php
$img = $row["resim"];

// URL mi yoksa dosya mı kontrolü
if(strpos($img, "http") === 0){
    echo '<img src="'.$img.'">';
}else{
    echo '<img src="uploads/'.$img.'">';
}
?>

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

</body>
</html>