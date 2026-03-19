<?php
include("baglan.php");

// Form gönderimi
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $film_id = $_POST['film'];
    $isim = $_POST['isim'];
    $email = $_POST['email'];
    $konum = $_POST['konum'];
    $seans = $_POST['seans'];
    $koltuklar = implode(",", $_POST['koltuk']); 
    $adet = count($_POST['koltuk']);

    $sqlInsert = "INSERT INTO biletler (film_id, konum, seans, koltuklar, isim, email, adet) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmtInsert = $baglan->prepare($sqlInsert);
    $stmtInsert->bind_param("isssssi", $film_id, $konum, $seans, $koltuklar, $isim, $email, $adet);
    $stmtInsert->execute();

    echo "<p style='color:lime; font-weight:bold;'>Biletiniz başarıyla alındı!</p>";
}

// Filmleri çek
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
    font-family: 'Poppins', sans-serif;
    padding:40px;
}
h2{ color:#ff2a2a; margin-bottom:20px; }

.container{
    display:flex;
    gap:40px;
    align-items:flex-start; /* üstte hizala */
}

/* Sol: Form */
.form-panel{
    flex:1;
    background:#121212;
    padding:30px;
    border-radius:10px;
    display:flex;
    flex-direction:column; /* dikey içeriği stackle */
}

.form-panel label{ margin-top:15px; margin-bottom:5px; font-weight:500; }
.form-panel input, .form-panel select{
    width:100%;
    padding:10px;
    border-radius:6px;
    border:none;
}
button{
    background:#ff2a2a; color:white; border:none; padding:12px 20px; border-radius:6px; cursor:pointer; font-weight:600; transition:.3s; margin-top:20px;
}
button:hover{ background:#e02121; }

/* Sağ: Mini salon panel */
.koltuk-panel{
    flex:1;
    background:#1a1a1a;
    padding:20px;
    border-radius:10px;
}

.koltuklar-salon{
    display:grid;
    grid-template-columns: repeat(5, 40px);
    gap:10px;
    justify-content:center;
    margin-top:20px;
}

.koltuk{
    width:40px;
    height:40px;
    background:#2b2b2b;
    border-radius:5px;
    display:flex;
    justify-content:center;
    align-items:center;
    cursor:pointer;
    user-select:none;
    transition:.3s;
}

.koltuk.selected{ background:#ff2a2a; }
.koltuk.occupied{ background:#555; cursor:not-allowed; }

.sira-label{ text-align:center; font-weight:bold; margin-top:10px; }
</style>
</head>
<body>

<h2>Bilet Satın Al</h2>

<div class="container">
    <!-- Sol Form -->
    <div class="form-panel">
        <form method="POST" id="biletForm">

            <label>Film:</label>
            <select name="film" required>
                <option value="">Seçiniz</option>
                <?php foreach($filmler as $film): ?>
                    <option value="<?php echo $film['id']; ?>"><?php echo $film['film_adi']; ?></option>
                <?php endforeach; ?>
            </select>

            <label>Konum:</label>
            <select name="konum" required>
                <option value="">Seçiniz</option>
                <option value="Salon 1">Salon 1</option>
                <option value="Salon 2">Salon 2</option>
                <option value="Salon 3">Salon 3</option>
            </select>

            <label>Seans:</label>
            <select name="seans" required>
                <option value="">Seçiniz</option>
                <option value="10:00">10:00</option>
                <option value="13:00">13:00</option>
                <option value="16:00">16:00</option>
                <option value="19:00">19:00</option>
                <option value="22:00">22:00</option>
            </select>

            <label>Adınız Soyadınız:</label>
            <input type="text" name="isim" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <!-- Seçilen koltuklar gizli input -->
            <input type="hidden" name="koltuk[]" id="koltukInput">

            <button type="submit">Satın Al</button>
        </form>
    </div>

    <!-- Sağ: Mini Salon -->
    <div class="koltuk-panel">
        <div class="sira-label">Ekran Burada</div>
        <div class="koltuklar-salon" id="salon">
            <?php
            $rows = ['A','B','C','D','E'];
            $cols = 5;
            foreach($rows as $r){
                for($c=1;$c<=$cols;$c++){
                    $koltuk = $r.$c;
                    echo "<div class='koltuk' data-koltuk='$koltuk'>$koltuk</div>";
                }
            }
            ?>
        </div>
    </div>
</div>

<script>
// Koltuk seçimi JS
const koltuklar = document.querySelectorAll(".koltuk");
const koltukInput = document.getElementById("koltukInput");
let secilenKoltuklar = [];

koltuklar.forEach(k => {
    k.addEventListener("click", ()=>{
        if(k.classList.contains("occupied")) return;

        if(k.classList.contains("selected")){
            k.classList.remove("selected");
            secilenKoltuklar = secilenKoltuklar.filter(x => x != k.dataset.koltuk);
        }else{
            if(secilenKoltuklar.length >= 5){
                alert("En fazla 5 koltuk seçebilirsiniz!");
                return;
            }
            k.classList.add("selected");
            secilenKoltuklar.push(k.dataset.koltuk);
        }
        koltukInput.value = secilenKoltuklar;
    });
});
</script>

</body>
</html>