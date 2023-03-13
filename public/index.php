<?php
require_once __DIR__ . '/../vendor/autoload.php';
//* Start Gira

use gira\controllers\loginController;
use gira\core\Gira;


$app = new Gira(dirname(__DIR__));
$app->router->get('/', 'home');
$app->router->get('/users', 'users');
$app->router->post('/users', [loginController::class, 'login']);


$app->run();
