<?php

use gira\controllers\HomeController;
use gira\controllers\LoginController;
use gira\controllers\RegisterController;
use gira\core\Gira;
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
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

$app->database->applyMigrations();
