<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Film Paneli</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial;
}

body{
background:#0b0b0b;
color:white;
}

/* ANA YAPI */

.container{
display:flex;
height:100vh;
}

/* SOL MENU */

.sidebar{
width:230px;
background:#121212;
padding:25px;
}

.logo{
font-size:22px;
font-weight:bold;
margin-bottom:40px;
}

.menu{
list-style:none;
}

.menu li{
padding:14px;
margin-bottom:10px;
border-radius:6px;
cursor:pointer;
}

.menu li:hover{
background:#1f1f1f;
}

/* ANA ALAN */

.main{
flex:1;
padding:30px;
}

/* ÜST BAR */

.topbar{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:40px;
}

.title{
font-size:26px;
font-weight:bold;
}

.admin{
width:45px;
height:45px;
border-radius:50%;
background:#2a2a2a;
display:flex;
align-items:center;
justify-content:center;
font-size:20px;
cursor:pointer;
}

/* FILM GRID */

.movies{
display:grid;
grid-template-columns:repeat(auto-fill,minmax(230px,1fr));
gap:25px;
}

/* FILM CARD */

.card{
background:#1a1a1a;
border-radius:12px;
overflow:hidden;
transition:0.3s;
}

.card:hover{
transform:scale(1.03);
}

.card img{
width:100%;
height:260px;
object-fit:cover;
}

/* CARD ALT */

.card-body{
padding:15px;
}

.movie-title{
font-size:16px;
font-weight:bold;
margin-bottom:12px;
}

/* IKONLAR */

.actions{
display:flex;
gap:10px;
}

.icon{
flex:1;
text-align:center;
padding:8px;
border-radius:6px;
background:#2d2d2d;
cursor:pointer;
transition:0.2s;
}

.icon:hover{
background:#3f3f3f;
}

</style>
</head>


<body>

<div class="container">

<!-- SOL MENU -->

<div class="sidebar">

<div class="logo">🎬 FilmPanel</div>

<ul class="menu">
<li>🏠 Ana Sayfa</li>
<li>🎞 Filmler</li>
<li>📂 Türler</li>
<li>⭐ Popüler</li>
<li>📅 Yakında</li>
<li>⚙ Ayarlar</li>
</ul>

</div>


<!-- ANA ALAN -->

<div class="main">

<div class="topbar">
<div class="title">Filmler</div>
<div class="admin">👤</div>
</div>


<div class="movies">

<!-- FILM -->

<div class="card">
<img src="https://picsum.photos/400/500?1">
<div class="card-body">

<div class="movie-title">Hızlı Görev</div>

<div class="actions">
<div class="icon">▶</div>
<div class="icon">✏</div>
<div class="icon">🗑</div>
</div>

</div>
</div>


<div class="card">
<img src="https://picsum.photos/400/500?2">
<div class="card-body">

<div class="movie-title">Son Savaş</div>

<div class="actions">
<div class="icon">▶</div>
<div class="icon">✏</div>
<div class="icon">🗑</div>
</div>

</div>
</div>


<div class="card">
<img src="https://picsum.photos/400/500?3">
<div class="card-body">

<div class="movie-title">Gece Operasyonu</div>

<div class="actions">
<div class="icon">▶</div>
<div class="icon">✏</div>
<div class="icon">🗑</div>
</div>

</div>
</div>


<div class="card">
<img src="https://picsum.photos/400/500?4">
<div class="card-body">

<div class="movie-title">Büyük Çarpışma</div>

<div class="actions">
<div class="icon">▶</div>
<div class="icon">✏</div>
<div class="icon">🗑</div>
</div>

</div>
</div>

</div>

</div>

</div>

</body>
</html>