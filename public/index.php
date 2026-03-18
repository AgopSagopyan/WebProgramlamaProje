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

define('ROOT', __DIR__ . '/../' );


require_once ROOT . '/app/config/database.php';

require_once ROOT . '/app/controllers/Controller.php';
require_once ROOT . '/app/repositories/Repository.php';
require_once ROOT . '/app/services/Services.php';

$repository = new Repository($pdo);

$service = new Services();

$controller = new Controller($pdo, $service);

$controller->navigateTo();



?>
