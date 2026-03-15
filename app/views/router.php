<?php
$path = __DIR__ . parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

if (is_file($path)) {
    return false;
}

echo "<h2>Files</h2>";
foreach (scandir(__DIR__) as $file) {
    if ($file !== '.') {
        echo "<a href='$file'>$file</a><br>";
    }
}
