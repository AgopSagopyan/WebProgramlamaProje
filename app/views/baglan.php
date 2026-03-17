<?php

$baglan = new mysqli("localhost", "root", "", "sinema");

if($baglan->connect_error){
    die("Bağlantı hatası");
}

?>