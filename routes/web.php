<?php

declare(strict_types=1);

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\Response;
use Laravel\Lumen\Routing\Router;

if (!isset($router)) {
    throw new RuntimeException('Router instance must be set');
}

$router->group([
    'namespace' => 'V1',
    'prefix' => 'api/v1',
    'middleware' => [
        Authenticate::class,
        Response::class,
    ],
], static function(Router $router) {
    $router->get('/', 'Router@route');
    $router->post('/', 'Router@route');
});

