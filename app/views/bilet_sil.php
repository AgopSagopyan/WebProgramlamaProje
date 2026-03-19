<?php
include("baglan.php");

$id = $_GET['id'] ?? 0;
if($id > 0){
    $sql = "DELETE FROM biletler WHERE id = ?";
    $stmt = $baglan->prepare($sql);
    $stmt->bind_param("i",$id);
    $stmt->execute();
}

echo "ok"; 