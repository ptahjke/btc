<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Http\Middleware\Authenticate;

if (!isset($router)) {
    throw new RuntimeException('Router instance must be set');
}

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group([
    'namespace' => 'V1',
    'prefix' => 'api/v1',
    'middleware' => [
        Authenticate::class,
    ],
], static function($router) {
    $router->get('/', 'Router@route');
    $router->post('/', 'Router@route');
});

