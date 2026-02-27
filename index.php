<?php
$host = '127.0.0.1';
$db   = 'my_app';
$user = 'root';
$pass = ''; // Default devenv mysql has no password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    echo "Connected to MariaDB successfully!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
