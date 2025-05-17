<?php

use Framework\Routing\Router;

return function (Router $r) {
    $r->addRoute('GET', '/', fn() => include __DIR__ . '../../resources/views/home.php');
    $r->addRoute('GET', '/product', fn() => include __DIR__ . '../../resources/views/product.php');
};
