<?php

use gira\controllers\HomeController;
use gira\controllers\LoginController;
use gira\controllers\RegisterController;
use gira\core\Gira;
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../views/Error/Error.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

//* Start Gira


$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ]
];


$app = new Gira($config);
$app->router->get('/', [HomeController::class, 'index']);
$app->router->get('/login', [LoginController::class, 'loginForm']);
$app->router->post('/login', [LoginController::class, 'login']);
$app->router->get('/register', [RegisterController::class, 'registerForm']);
$app->router->post('/register', [RegisterController::class, 'register']);

$app->run();
