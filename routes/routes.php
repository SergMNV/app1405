<?php

use Framework\Routing\Router;

return function (Router $r) {
    $r->addRoute(
        'GET',
        '/',
        fn() => include(
            dirname(__DIR__) . '/resources/views/home.php')
    );

    $r->addRoute(
        'GET',
        '/product',
        fn() => include(
            dirname(__DIR__) . '/resources/views/product.php')
    );

    // $r->setErrorHandler(
    //     400,
    //     fn() => include(dirname(__DIR__) . '/resources/views/includes/400.php')
    // );

    $r->setErrorHandler(
        400,
        fn() => 'dispatch not allowed 400'
    );

    $r->setErrorHandler(
        404,
        fn() => include(dirname(__DIR__) . '/resources/views/includes/404.php')
    );
};
