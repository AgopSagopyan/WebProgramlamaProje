<?php
include("baglan.php");

// TÜM DOLU KOLTUKLARI ÇEK (film + salon + seans bazlı)
$doluKoltuklar = [];

$sqlDolu = "SELECT film_id, konum, seans, koltuklar FROM biletler";
$resDolu = $baglan->query($sqlDolu);

while($row = $resDolu->fetch_assoc()){
    $koltuklar = explode(",", $row['koltuklar']);
    foreach($koltuklar as $k){
        $doluKoltuklar[] = [
            "film_id" => $row['film_id'],
            "konum" => $row['konum'],
            "seans" => $row['seans'],
            "koltuk" => $k
        ];
    }
}


// FORM GÖNDERİMİ
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $film_id = $_POST['film'];
    $isim = $_POST['isim'];
    $email = $_POST['email'];
    $konum = $_POST['konum'];
    $seans = $_POST['seans'];
    $koltuklarArray = $_POST['koltuk'];
    $koltuklar = implode(",", $koltuklarArray);
    $adet = count($koltuklarArray);

    // ÇAKIŞMA KONTROLÜ
    $sqlCheck = "SELECT koltuklar FROM biletler WHERE film_id=? AND konum=? AND seans=?";
    $stmtCheck = $baglan->prepare($sqlCheck);
    $stmtCheck->bind_param("iss", $film_id, $konum, $seans);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    $dolu = [];

    while($row = $resultCheck->fetch_assoc()){
        $kDB = explode(",", $row['koltuklar']);
        $dolu = array_merge($dolu, $kDB);
    }

    $cakisiyor = array_intersect($koltuklarArray, $dolu);

    if(!empty($cakisiyor)){
        echo "<p style='color:red; font-weight:bold;'>Seçilen koltuklardan bazıları dolu!</p>";
    }else{

        $sqlInsert = "INSERT INTO biletler (film_id, konum, seans, koltuklar, isim, email, adet) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmtInsert = $baglan->prepare($sqlInsert);
        $stmtInsert->bind_param("isssssi", $film_id, $konum, $seans, $koltuklar, $isim, $email, $adet);
        $stmtInsert->execute();

        echo "<p style='color:lime; font-weight:bold;'>Bilet başarıyla alındı!</p>";
    }
}


// FİLMLER
$filmler = [];
$sql = "SELECT * FROM filmler ORDER BY film_adi ASC";
$result = $baglan->query($sql);

while($row = $result->fetch_assoc()){
    $filmler[] = $row;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Bilet Satın Al</title>

<style>
body{
    background:#0e0e0e;
    color:white;
    font-family: Arial;
    padding:40px;
}

.container{
    display:flex;
    gap:40px;
}

.form-panel{
    flex:1;
    background:#121212;
    padding:30px;
    border-radius:10px;
}

.form-panel input, .form-panel select{
    width:100%;
    padding:10px;
    margin-top:10px;
}

button{
    margin-top:20px;
    padding:12px;
    background:red;
    color:white;
    border:none;
    cursor:pointer;
}

.koltuk-panel{
    flex:1;
    background:#1a1a1a;
    padding:20px;
    border-radius:10px;
}

.koltuklar{
    display:grid;
    grid-template-columns: repeat(5, 50px);
    gap:10px;
    justify-content:center;
}

.koltuk{
    width:50px;
    height:50px;
    background:#2b2b2b;
    display:flex;
    justify-content:center;
    align-items:center;
    cursor:pointer;
}

.selected{ background:red; }
.occupied{ background:#555; cursor:not-allowed; }
</style>

</head>
<body>

<h2>Bilet Satın Al</h2>

<div class="container">

<div class="form-panel">
<form method="POST">

<select name="film" required>
<option value="">Film seç</option>
<?php foreach($filmler as $film): ?>
<option value="<?= $film['id'] ?>"><?= $film['film_adi'] ?></option>
<?php endforeach; ?>
</select>

<select name="konum" required>
<option value="">Salon</option>
<option>Salon 1</option>
<option>Salon 2</option>
<option>Salon 3</option>
</select>

<select name="seans" required>
<option value="">Seans</option>
<option>10:00</option>
<option>13:00</option>
<option>16:00</option>
<option>19:00</option>
<option>22:00</option>
</select>

<input type="text" name="isim" placeholder="Ad Soyad" required>
<input type="email" name="email" placeholder="Email" required>

<input type="hidden" name="koltuk[]" id="koltukInput">

<button>Satın Al</button>

</form>
</div>

<div class="koltuk-panel">
<div class="koltuklar" id="salon">

<?php
$rows = ['A','B','C','D','E'];
foreach($rows as $r){
    for($i=1;$i<=5;$i++){
        $k = $r.$i;
        echo "<div class='koltuk' data-koltuk='$k'>$k</div>";
    }
}
?>

</div>
</div>

</div>

<script>
let doluKoltuklar = <?php echo json_encode($doluKoltuklar); ?>;

const koltuklar = document.querySelectorAll(".koltuk");
const input = document.getElementById("koltukInput");

let secilen = [];

//Dolu Koltuklar (Gri)
koltuklar.forEach(k => {
    doluKoltuklar.forEach(d => {
        if(k.dataset.koltuk === d.koltuk){
            k.classList.add("occupied");
        }
    });

    k.addEventListener("click", () => {
        if(k.classList.contains("occupied")) return;

        if(k.classList.contains("selected")){
            k.classList.remove("selected");
            secilen = secilen.filter(x => x != k.dataset.koltuk);
        }else{
            if(secilen.length >= 5){
                alert("Max 5 koltuk");
                return;
            }
            k.classList.add("selected");
            secilen.push(k.dataset.koltuk);
        }

        input.value = secilen;
    });
});
</script>

</body>
</html>