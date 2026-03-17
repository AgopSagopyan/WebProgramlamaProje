<?php
/*
require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../app/controllers/Controller.php';

$controller = new Controller($pdo);
$controller->handleRequest();

require __DIR__ . '/../app/views/anasayfa.php';

//header("Location: /../app/views/anasayfa.php");
exit();
*/

require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../app/controllers/Controller.php';
require_once __DIR__ . '/../app/repositories/Repository.php';

$repository = new Repository($pdo);

$controller = new Controller($pdo, $repository);

$controller->bisey();



?>
