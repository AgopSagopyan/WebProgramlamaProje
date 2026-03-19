<?php
include("baglan.php");

// Biletleri çek
$sql = "SELECT biletler.*, filmler.film_adi FROM biletler
        JOIN filmler ON biletler.film_id = filmler.id
        ORDER BY tarih DESC";
$result = $baglan->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Admin Panel - Biletler</title>
<style>
body{
    background:#0e0e0e;
    color:white;
    font-family: 'Poppins', sans-serif;
    padding:40px;
}
h2{
    color:#ff2a2a;
    margin-bottom:20px;
}

/* Tablo stili */
table{
    width:100%;
    border-collapse: collapse;
}
th, td{
    padding:12px;
    border:1px solid #444;
    text-align:center;
}
th{
    background:#ff2a2a;
    color:white;
}
tr:nth-child(even){
    background:#1a1a1a;
}
tr:nth-child(odd){
    background:#121212;
}

/* Sil butonu */
a.silBtn{
    color:white;
    background:red;
    padding:5px 10px;
    border-radius:5px;
    text-decoration:none;
    transition:.3s;
}
a.silBtn:hover{
    background:#e02121;
}

/* Admin panel container */
.container{
    max-width:1200px;
    margin:auto;
}
</style>
</head>
<body>

<div class="container">
    <h2>Alınan Biletler</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Film</th>
            <th>Konum</th>
            <th>Seans</th>
            <th>Koltuklar</th>
            <th>İsim</th>
            <th>Email</th>
            <th>Adet</th>
            <th>Tarih</th>
            <th>İşlem</th>
        </tr>

        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['film_adi']; ?></td>
            <td><?php echo $row['konum']; ?></td>
            <td><?php echo $row['seans']; ?></td>
            <td><?php echo $row['koltuklar']; ?></td>
            <td><?php echo $row['isim']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['adet']; ?></td>
            <td><?php echo $row['tarih']; ?></td>
            <td>
                <button class="silBtn" data-id="<?php echo $row['id']; ?>">Sil</button>
            </td>
        </tr>
        <?php endwhile; ?>

        <script>
const silBtns = document.querySelectorAll(".silBtn");

silBtns.forEach(btn=>{
    btn.addEventListener("click", ()=>{
        const id = btn.dataset.id;
        if(confirm("Bu bileti silmek istediğinize emin misiniz?")){
            fetch("bilet_sil.php?id="+id)
                .then(res=>res.text())
                .then(data=>{
                    btn.closest("tr").remove(); // tablodan satırı kaldır
                });
        }
    });
});
</script>

    </table>
</div>

</body>
</html>