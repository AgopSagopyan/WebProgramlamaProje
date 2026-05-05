<?php
session_start();

session_destroy();

setcookie("kullanici_id", "", time()-3600, "/");
setcookie("kullanici_isim", "", time()-3600, "/");

header("Location: anasayfa.php");
exit;
?>