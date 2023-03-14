<?php
require_once __DIR__ . '/../vendor/autoload.php';
//* Start Gira

use gira\controllers\HomeController;
use gira\controllers\LoginController;
use gira\controllers\RegisterController;
use gira\core\Gira;


$app = new Gira(dirname(__DIR__));
$app->router->get('/', [HomeController::class, 'index']);
$app->router->get('/login', [LoginController::class, 'loginForm']);
$app->router->post('/login', [LoginController::class, 'login']);
$app->router->get('/register', [RegisterController::class, 'registerForm']);
$app->router->post('/register', [RegisterController::class, 'register']);

$app->run();
