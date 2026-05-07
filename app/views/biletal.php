<?php
session_start();
include("baglan.php");

/* COOKIE → SESSION */
if(!isset($_SESSION['kullanici_id']) && isset($_COOKIE['kullanici_id'])){

    $_SESSION['kullanici_id'] = $_COOKIE['kullanici_id'];
    $_SESSION['kullanici_isim'] = $_COOKIE['kullanici_isim'];
    $_SESSION['kullanici_email'] = $_COOKIE['kullanici_email'];
}

/* GİRİŞ YAPMAMIŞSA */
if(!isset($_SESSION['kullanici_id'])){
    header("Location: giris.php");
    exit();
}

/* DOLU KOLTUKLARI ÇEK */
$doluKoltuklar = [];

$sqlDolu = "SELECT film_id, konum, seans, koltuklar FROM biletler";

$resDolu = $baglan->query($sqlDolu);

while($row = $resDolu->fetch_assoc()){

    $koltuklar = explode(",", $row['koltuklar']);

    foreach($koltuklar as $k){

        $doluKoltuklar[] = [
            "film_id" => trim($row['film_id']),
            "konum" => trim($row['konum']),
            "seans" => trim($row['seans']),
            "koltuk" => trim($k)
        ];
    }
}

/* SATIN AL */
$mesaj = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $film_id = $_POST['film'];

    /* SESSIONDAN ÇEK */
    $isim = $_SESSION['kullanici_isim'];
    $email = $_SESSION['kullanici_email'];

    $konum = $_POST['konum'];
    $seans = $_POST['seans'];

    $koltuklarArray = isset($_POST['koltuk']) ? $_POST['koltuk'] : [];

    if(empty($koltuklarArray)){

        $mesaj = "
        <div class='error-box'>
            Lütfen koltuk seçiniz.
        </div>
        ";

    }else{

        $koltuklar = implode(",", $koltuklarArray);

        $adet = count($koltuklarArray);

        /* ÇAKIŞMA */

        $sqlCheck = "SELECT koltuklar FROM biletler
        WHERE film_id=? AND konum=? AND seans=?";

        $stmtCheck = $baglan->prepare($sqlCheck);

        $stmtCheck->bind_param(
            "iss",
            $film_id,
            $konum,
            $seans
        );

        $stmtCheck->execute();

        $resultCheck = $stmtCheck->get_result();

        $dolu = [];

        while($row = $resultCheck->fetch_assoc()){

            $dolu = array_merge(
                $dolu,
                explode(",", $row['koltuklar'])
            );
        }

        $cakisiyor = array_intersect($koltuklarArray, $dolu);

        if(!empty($cakisiyor)){

            $mesaj = "
            <div class='error-box'>
                Seçilen koltuklardan biri dolu.
            </div>
            ";

        }else{

            $sqlInsert = "INSERT INTO biletler
            (film_id, konum, seans, koltuklar, isim, email, adet)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

            $stmtInsert = $baglan->prepare($sqlInsert);

            $stmtInsert->bind_param(
                "isssssi",
                $film_id,
                $konum,
                $seans,
                $koltuklar,
                $isim,
                $email,
                $adet
            );

            $stmtInsert->execute();

            $mesaj = "
            <div class='success-box'>
                Bilet başarıyla satın alındı 🎟
            </div>
            ";
        }
    }
}

/* FİLMLER */
$filmler = $baglan->query("
SELECT * FROM filmler
ORDER BY film_adi ASC
");
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Bilet Satın Al</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:#0e0e0e;
color:white;
padding:40px;
}

/* NAVBAR */

.navbar{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:40px;
}

.logo{
font-size:30px;
font-weight:700;
color:#ff2a2a;
}

.user{
background:#1a1a1a;
padding:12px 18px;
border-radius:10px;
}

/* ALERT */

.success-box{
background:#14532d;
padding:15px;
border-radius:10px;
margin-bottom:25px;
text-align:center;
font-weight:600;
}

.error-box{
background:#7f1d1d;
padding:15px;
border-radius:10px;
margin-bottom:25px;
text-align:center;
font-weight:600;
}

/* CONTAINER */

.container{
display:flex;
gap:40px;
align-items:flex-start;
}

/* FORM */

.form-panel{
flex:1;
background:#121212;
padding:35px;
border-radius:16px;
}

.form-panel h2{
margin-bottom:25px;
font-size:28px;
}

.form-panel select{
width:100%;
padding:14px;
margin-top:15px;
background:#1d1d1d;
border:none;
border-radius:10px;
color:white;
font-size:15px;
}

.buy-btn{
width:100%;
padding:15px;
background:#ff2a2a;
border:none;
border-radius:10px;
color:white;
font-size:16px;
font-weight:600;
cursor:pointer;
margin-top:25px;
transition:.3s;
}

.buy-btn:hover{
background:#e02121;
}

/* KOLTUK */

.koltuk-panel{
flex:1;
background:#121212;
padding:35px;
border-radius:16px;
}

.koltuk-title{
text-align:center;
font-size:28px;
margin-bottom:20px;
}

.koltuklar{
display:grid;
grid-template-columns:repeat(5,60px);
gap:14px;
justify-content:center;
margin-top:20px;
}

.koltuk{
width:60px;
height:60px;
background:#2b2b2b;
display:flex;
justify-content:center;
align-items:center;
border-radius:10px;
cursor:pointer;
transition:.2s;
font-weight:600;
}

.koltuk:hover{
transform:scale(1.06);
}

.selected{
background:#ff2a2a !important;
}

.occupied{
background:#666 !important;
cursor:not-allowed;
pointer-events:none;
color:#d1d1d1;
}

/* RESPONSIVE */

@media(max-width:900px){

.container{
flex-direction:column;
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

<div class="user">
👤 <?= $_SESSION['kullanici_isim']; ?>
</div>

</div>

<?= $mesaj ?>

<div class="container">

<!-- SOL -->

<div class="form-panel">

<h2>Bilet Satın Al</h2>

<form method="POST">

<select name="film" id="film" required>

<option value="">Film Seç</option>

<?php while($film = $filmler->fetch_assoc()){ ?>

<option value="<?= $film['id'] ?>">
<?= $film['film_adi'] ?>
</option>

<?php } ?>

</select>

<select name="konum" id="konum" required>

<option value="">Salon Seç</option>

<option value="Salon 1">Salon 1</option>
<option value="Salon 2">Salon 2</option>
<option value="Salon 3">Salon 3</option>

</select>

<select name="seans" id="seans" required>

<option value="">Seans Seç</option>

<option value="10:00">10:00</option>
<option value="13:00">13:00</option>
<option value="16:00">16:00</option>
<option value="19:00">19:00</option>
<option value="22:00">22:00</option>

</select>

<!-- KOLTUK INPUTLARI -->

<div id="hiddenInputs"></div>

<button type="submit" class="buy-btn">
Bileti Satın Al
</button>

</form>

</div>

<!-- SAĞ -->

<div class="koltuk-panel">

<div class="koltuk-title">
Koltuk Seç
</div>

<div class="koltuklar">

<?php

$rows = ['A','B','C','D','E'];

foreach($rows as $r){

    for($i=1; $i<=5; $i++){

        $koltuk = $r.$i;

        echo "
        <div class='koltuk' data-koltuk='$koltuk'>
            $koltuk
        </div>
        ";
    }
}

?>

</div>

</div>

</div>

<script>

let doluKoltuklar = <?php echo json_encode($doluKoltuklar); ?>;

const film = document.getElementById("film");
const konum = document.getElementById("konum");
const seans = document.getElementById("seans");

const koltuklar = document.querySelectorAll(".koltuk");

const hiddenInputs = document.getElementById("hiddenInputs");

let secilen = [];

/* DOLU KOLTUKLARI GÜNCELLE */

function koltukGuncelle(){

    koltuklar.forEach(k => {

        k.classList.remove("occupied");
        k.classList.remove("selected");
    });

    secilen = [];

    hiddenInputs.innerHTML = "";

    const seciliFilm = film.value;
    const seciliKonum = konum.value;
    const seciliSeans = seans.value;

    if(!seciliFilm || !seciliKonum || !seciliSeans){
        return;
    }

    doluKoltuklar.forEach(d => {

        if(
            d.film_id == seciliFilm &&
            d.konum == seciliKonum &&
            d.seans == seciliSeans
        ){

            koltuklar.forEach(k => {

                if(k.dataset.koltuk.trim() == d.koltuk.trim()){

                    k.classList.add("occupied");
                }
            });
        }
    });
}

/* SELECT */

film.addEventListener("change", koltukGuncelle);
konum.addEventListener("change", koltukGuncelle);
seans.addEventListener("change", koltukGuncelle);

/* KOLTUK */

koltuklar.forEach(k => {

    k.addEventListener("click", () => {

        if(k.classList.contains("occupied")){
            return;
        }

        const koltukNo = k.dataset.koltuk;

        if(k.classList.contains("selected")){

            k.classList.remove("selected");

            secilen = secilen.filter(x => x != koltukNo);

        }else{

            if(secilen.length >= 5){

                alert("En fazla 5 koltuk seçebilirsin");
                return;
            }

            k.classList.add("selected");

            secilen.push(koltukNo);
        }

        hiddenInputs.innerHTML = "";

        secilen.forEach(s => {

            hiddenInputs.innerHTML += `
            <input type="hidden" name="koltuk[]" value="${s}">
            `;
        });
    });
});

/* SAYFA YÜKLENİNCE */

koltukGuncelle();

</script>

</body>
</html>