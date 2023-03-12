<?php
require_once __DIR__ . '/../vendor/autoload.php';
//* Start Gira
use gira\core\Gira;


$app = new Gira();
$app->router->get('/', function () {
    return 'main page';
});
$app->router->get('/users', function () {
    return 'user page';
});
$app->run();
