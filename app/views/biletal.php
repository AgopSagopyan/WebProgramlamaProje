<?php
include("baglan.php");

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
if($_SERVER['REQUEST_METHOD'] == "POST"){

    $film_id = $_POST['film'];
    $isim = $_POST['isim'];
    $email = $_POST['email'];
    $konum = $_POST['konum'];
    $seans = $_POST['seans'];

    $koltuklarArray = isset($_POST['koltuk']) ? $_POST['koltuk'] : [];

    if(empty($koltuklarArray)){
        echo "<p style='color:red;text-align:center;'>Koltuk seçiniz.</p>";
    }else{

        $koltuklar = implode(",", $koltuklarArray);
        $adet = count($koltuklarArray);

        /* ÇAKIŞMA KONTROL */

        $sqlCheck = "SELECT koltuklar FROM biletler 
        WHERE film_id=? AND konum=? AND seans=?";

        $stmtCheck = $baglan->prepare($sqlCheck);

        $stmtCheck->bind_param("iss", $film_id, $konum, $seans);

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

            echo "<p style='color:red;text-align:center;'>Seçilen koltuk dolu!</p>";

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

            echo "<p style='color:lime;text-align:center;'>Bilet alındı!</p>";
        }
    }
}

/* FİLMLER */
$filmler = $baglan->query("SELECT * FROM filmler ORDER BY film_adi ASC");
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Bilet Al</title>

<style>

body{
    background:#0e0e0e;
    color:white;
    font-family:Arial;
    padding:40px;
}

.container{
    display:flex;
    gap:40px;
    align-items:flex-start;
}

/* FORM PANEL */

.form-panel{
    flex:1;
    background:#121212;
    padding:30px;
    border-radius:12px;
}

.form-panel h3{
    margin-bottom:20px;
}

.form-panel input,
.form-panel select{
    width:100%;
    padding:12px;
    margin-top:12px;
    background:#1a1a1a;
    border:none;
    color:white;
    border-radius:6px;
}

.form-panel button{
    margin-top:20px;
    width:100%;
    padding:12px;
    background:red;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

/* KOLTUK PANEL */

.koltuk-panel{
    flex:1;
    background:#1a1a1a;
    padding:25px;
    border-radius:12px;
}

.koltuklar{
    display:grid;
    grid-template-columns:repeat(5,55px);
    gap:12px;
    justify-content:center;
    margin-top:20px;
}

.koltuk{
    width:55px;
    height:55px;
    background:#2b2b2b;
    display:flex;
    justify-content:center;
    align-items:center;
    border-radius:6px;
    cursor:pointer;
    transition:.2s;
}

.koltuk:hover{
    background:#444;
}

.selected{
    background:red !important;
}

.occupied{
    background:#666 !important;
    cursor:not-allowed !important;
    pointer-events:none;
    color:#d1d1d1;
}

</style>
</head>

<body>

<h2 style="text-align:center;margin-bottom:30px;">
Bilet Satın Al
</h2>

<div class="container">

<!-- SOL FORM -->

<div class="form-panel">

<h3>Bilgiler</h3>

<form method="POST">

<select name="film" id="film" required>

<option value="">Film seç</option>

<?php while($film = $filmler->fetch_assoc()){ ?>

<option value="<?= $film['id'] ?>">
<?= $film['film_adi'] ?>
</option>

<?php } ?>

</select>

<select name="konum" id="konum" required>
<option value="">Salon seç</option>
<option value="Salon 1">Salon 1</option>
<option value="Salon 2">Salon 2</option>
<option value="Salon 3">Salon 3</option>
</select>

<select name="seans" id="seans" required>
<option value="">Seans seç</option>
<option value="10:00">10:00</option>
<option value="13:00">13:00</option>
<option value="16:00">16:00</option>
<option value="19:00">19:00</option>
<option value="22:00">22:00</option>
</select>

<input type="text" name="isim" placeholder="Ad Soyad" required>

<input type="email" name="email" placeholder="Email" required>

<!-- SEÇİLEN KOLTUKLAR -->

<div id="hiddenInputs"></div>

<button type="submit">
Satın Al
</button>

</form>

</div>

<!-- SAĞ KOLTUKLAR -->

<div class="koltuk-panel">

<h3 style="text-align:center;">
Koltuk Seç
</h3>

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

/* SELECTLER */

film.addEventListener("change", koltukGuncelle);
konum.addEventListener("change", koltukGuncelle);
seans.addEventListener("change", koltukGuncelle);

/* KOLTUK TIKLAMA */

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

        /* INPUTLARI YENİLE */

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