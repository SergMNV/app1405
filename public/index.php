<?php

require_once __DIR__ . '../../vendor/autoload.php';

$routes = include __DIR__ . '../../routes/routes.php';

include_once 'test_url.php';

$router = new Framework\Routing\Router();
$routes($router);

$router->dispatch();
die;