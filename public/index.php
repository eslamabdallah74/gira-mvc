<?php
require_once __DIR__ . '/../vendor/autoload.php';
//* Start Gira

use gira\controllers\HomeController;
use gira\controllers\loginController;
use gira\core\Gira;


$app = new Gira(dirname(__DIR__));
$app->router->get('/', [HomeController::class,'index']);
$app->router->get('/users', [loginController::class, 'index']);
$app->router->post('/users', [loginController::class, 'login']);


$app->run();
