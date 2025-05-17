<?php

require_once __DIR__ . '../../vendor/autoload.php';

$routes = include __DIR__ . '../../routes/routes.php';
$router = new Framework\Routing\Router();
$routes($router);

print $router->dispatch();
die;