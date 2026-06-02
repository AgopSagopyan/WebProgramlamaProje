<?php
session_start();
include("baglan.php");

if(!isset($_SESSION['kullanici_id']) && isset($_COOKIE['kullanici_id'])){
    $_SESSION['kullanici_id'] = $_COOKIE['kullanici_id'];
    $_SESSION['kullanici_isim'] = $_COOKIE['kullanici_isim'];
    $_SESSION['kullanici_email'] = $_COOKIE['kullanici_email'];
}
if(!isset($_SESSION['kullanici_id'])){
    header("Location: giris.php");
    exit();
}

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

$mesaj = "";
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $film_id = $_POST['film'];
    $isim = $_SESSION['kullanici_isim'];
    $email = $_SESSION['kullanici_email'];
    $konum = $_POST['konum'];
    $seans = $_POST['seans'];
    $koltuklarArray = isset($_POST['koltuk']) ? $_POST['koltuk'] : [];

    if(empty($koltuklarArray)){
        $mesaj = "<div class='error-box'>Lütfen koltuk seçiniz.</div>";
    }else{
        $koltuklar = implode(",", $koltuklarArray);
        $adet = count($koltuklarArray);

        $sqlCheck = "SELECT koltuklar FROM biletler WHERE film_id=? AND konum=? AND seans=?";
        $stmtCheck = $baglan->prepare($sqlCheck);
        $stmtCheck->bind_param("iss", $film_id, $konum, $seans);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();
        
        $dolu = [];
        while($row = $resultCheck->fetch_assoc()){
            $dolu = array_merge($dolu, explode(",", $row['koltuklar']));
        }
        
        $cakisiyor = array_intersect($koltuklarArray, $dolu);
        if(!empty($cakisiyor)){
            $mesaj = "<div class='error-box'>Seçilen koltuklardan biri dolu.</div>";
        }else{
            $sqlInsert = "INSERT INTO biletler (film_id, konum, seans, koltuklar, isim, email, adet) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmtInsert = $baglan->prepare($sqlInsert);
            $stmtInsert->bind_param("isssssi", $film_id, $konum, $seans, $koltuklar, $isim, $email, $adet);
            $stmtInsert->execute();
            $mesaj = "<div class='success-box'>Bilet başarıyla satın alındı 🎟</div>";
        }
    }
}
$filmler = $baglan->query("SELECT * FROM filmler ORDER BY film_adi ASC");
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bilet Satın Al</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.7/build/pannellum.css"/>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/pannellum@2.5.7/build/pannellum.js"></script>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
        body{background:#0e0e0e;color:white;padding:40px;}
        .navbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:40px;}
        .logo{font-size:32px;font-weight:700;color:#ff2a2a;}
        .user{background:#1a1a1a;padding:12px 18px;border-radius:12px;}
        .success-box{background:#14532d;padding:15px;border-radius:12px;margin-bottom:25px;text-align:center;font-weight:600;}
        .error-box{background:#7f1d1d;padding:15px;border-radius:12px;margin-bottom:25px;text-align:center;font-weight:600;}
        .container{display:flex;gap:40px;align-items:flex-start;}
        .form-panel{flex:1;background:#121212;padding:35px;border-radius:20px;}
        .form-panel h2{margin-bottom:25px;font-size:28px;}
        .form-panel select{width:100%;padding:14px;margin-top:15px;background:#1d1d1d;border:none;border-radius:12px;color:white;font-size:15px;outline:none;}
        .buy-btn{width:100%;padding:15px;background:#ff2a2a;border:none;border-radius:12px;color:white;font-size:16px;font-weight:600;cursor:pointer;margin-top:25px;transition:.3s;}
        .buy-btn:hover{background:#e02121;}
        .koltuk-panel{flex:1;background:#121212;padding:35px;border-radius:20px;}
        .koltuk-title{text-align:center;font-size:28px;margin-bottom:25px;font-weight:600;}
        .screen{width:100%;height:14px;background:white;border-radius:50px;margin-bottom:40px;box-shadow:0 0 25px rgba(255,255,255,.8);}
        .koltuklar{display:grid;grid-template-columns:repeat(5,60px);gap:14px;justify-content:center;}
        .koltuk{width:60px;height:60px;background:#2b2b2b;display:flex;justify-content:center;align-items:center;border-radius:12px;cursor:pointer;transition:.2s;font-weight:600;}
        .koltuk:hover{transform:scale(1.08);}
        .selected{background:#ff2a2a !important;}
        .occupied{background:#666 !important;cursor:not-allowed;pointer-events:none;color:#ddd;}

        /* ENTEGRE EDİLEN YENİ SARMALAYICI VE BUTON DÜZENLEMESİ */
        .panorama-wrapper {
            position: relative;
            width: 100%;
            height: 400px;
            border-radius: 6px;
            overflow: hidden;
        }
        #panorama {
            width: 100%;
            height: 100%;
            background: #000;
        }
        dialog {
            width: 50vw;
            height: 60vh;
            margin: auto; 
            border: none;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            padding: 0;
            background: #121212;
            color: white;
        }
        .popup-content {
            display: flex;
            flex-direction: column;
            height: 100%;
            box-sizing: border-box;
            padding: 25px;
        }
        .popup-body {
            flex-grow: 1;
            overflow-y: auto;
        }
        .close-btn {
            align-self: flex-end;
            padding: 8px 16px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            font-weight: 600;
        }
        dialog::backdrop {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
        }
        .select-seat-btn {
            position: absolute;
            bottom: 20px;
            right: 20px;
            z-index: 99999; /* Pannellum arayüzünün en üstünde kalması sağlandı */
            padding: 12px 24px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            color: white;
            border: none;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.6);
            transition: 0.2s;
        }
        .select-seat-btn:hover {
            transform: scale(1.04);
        }
        @media(max-width:900px){.container{flex-direction:column;} dialog { width: 90vw; height: 70vh; }}
    </style>
</head>
<body>
<div class="navbar">
    <div class="logo">CineDavud</div>
    <div class="user">👤 <?= $_SESSION['kullanici_isim']; ?></div>
</div>
<?= $mesaj ?>
<div class="container">
    <div class="form-panel">
        <h2>Bilet Satın Al</h2>
        <form method="POST">
            <select name="film" id="film" required>
                <option value="">Film Seç</option>
                <?php while($film = $filmler->fetch_assoc()){ ?>
                    <option value="<?= $film['id'] ?>"><?= $film['film_adi'] ?></option>
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
            <div id="hiddenInputs"></div>
            <button type="submit" class="buy-btn">Bileti Satın Al</button>
        </form>
    </div>
    <div class="koltuk-panel">
        <div class="koltuk-title">Koltuk Seç</div>
        <div class="screen"></div>
        <div class="koltuklar">
            <?php
            $rows = ['A','B','C','D','E'];
            foreach($rows as $r){
                for($i=1; $i<=5; $i++){
                    $koltuk = $r.$i;
                    echo "<div class='koltuk' data-koltuk='$koltuk'>$koltuk</div>";
                }
            }
            ?>
        </div>
    </div>
</div>

<dialog id="myPopup">
    <div class="popup-content">
        <div class="popup-body">
            <h2 id="popupTitle" style="margin-bottom:15px;">🎬 Koltuk Görünümü</h2>
            <div class="panorama-wrapper">
                <div id="panorama"></div>
                <button id="modalSecBtn" class="select-seat-btn"></button>
            </div>
            <hr style="margin:15px 0; border:0; border-top:1px solid #333;">
            <p style="font-size:14px; color:#aaa;">Görünümü inceledikten sonra sağ alttaki butondan koltuğu seçebilir veya kaldırabilirsiniz.</p>
        </div>
        <button id="closePopup" class="close-btn">Kapat</button>
    </div>
</dialog>

<script>
let doluKoltuklar = <?php echo json_encode($doluKoltuklar); ?>;
const film = document.getElementById("film");
const konum = document.getElementById("konum");
const seans = document.getElementById("seans");
const koltuklar = document.querySelectorAll(".koltuk");
const hiddenInputs = document.getElementById("hiddenInputs");

const popup = document.getElementById('myPopup');
const closeBtn = document.getElementById('closePopup');
const popupTitle = document.getElementById('popupTitle');
const modalSecBtn = document.getElementById('modalSecBtn');

let pViewer = null;
let secilen = [];
let aktifKoltukNode = null;

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
    if(!seciliFilm || !seciliKonum || !seciliSeans) return;
    doluKoltuklar.forEach(d => {
        if(d.film_id == seciliFilm && d.konum == seciliKonum && d.seans == seciliSeans){
            koltuklar.forEach(k => {
                if(k.dataset.koltuk.trim() == d.koltuk.trim()){
                    k.classList.add("occupied");
                }
            });
        }
    });
}
film.addEventListener("change", koltukGuncelle);
konum.addEventListener("change", koltukGuncelle);
seans.addEventListener("change", koltukGuncelle);

koltuklar.forEach(k => {
    k.addEventListener("click", () => {
        if(k.classList.contains("occupied")) return;
        
        aktifKoltukNode = k;
        const koltukNo = k.dataset.koltuk;
        
        popupTitle.innerHTML = `🎬 ${koltukNo} Koltuk Görünümü`;
        
        if(k.classList.contains("selected")){
            modalSecBtn.innerText = "Seçimi Kaldır ❌";
            modalSecBtn.style.backgroundColor = "#dc3545";
        } else {
            modalSecBtn.innerText = "Koltuğu Seç 🎯";
            modalSecBtn.style.backgroundColor = "#28a745";
        }

        popup.showModal();

        if(pViewer) {
            pViewer.destroy();
            pViewer = null;
        }
        
        pViewer = pannellum.viewer('panorama', {
            "type": "equirectangular",
            "panorama": "sinema360.jpg",
            "autoLoad": true
        });
    });
});

modalSecBtn.addEventListener("click", () => {
    if(!aktifKoltukNode) return;
    const koltukNo = aktifKoltukNode.dataset.koltuk;

    if(aktifKoltukNode.classList.contains("selected")){
        aktifKoltukNode.classList.remove("selected");
        secilen = secilen.filter(x => x != koltukNo);
    }else{
        if(secilen.length >= 5){
            alert("En fazla 5 koltuk seçebilirsin");
            return;
        }
        aktifKoltukNode.classList.add("selected");
        secilen.push(koltukNo);
    }

    hiddenInputs.innerHTML = "";
    secilen.forEach(s => {
        hiddenInputs.innerHTML += `<input type="hidden" name="koltuk[]" value="${s}">`;
    });

    popup.close();
    if(pViewer) { pViewer.destroy(); pViewer = null; }
});

closeBtn.addEventListener('click', () => {
    popup.close();
    if(pViewer) { pViewer.destroy(); pViewer = null; }
});

popup.addEventListener('click', (lightBox) => {
    const dialogDimensions = popup.getBoundingClientRect();
    if (
        lightBox.clientX < dialogDimensions.left ||
        lightBox.clientX > dialogDimensions.right ||
        lightBox.clientY < dialogDimensions.top ||
        lightBox.clientY > dialogDimensions.bottom
    ) {
        popup.close();
        if(pViewer) { pViewer.destroy(); pViewer = null; }
    }
});

koltukGuncelle();
</script>
</body>
</html>