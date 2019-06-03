<?php

use Illuminate\Routing\Router;

/**
 * @var Router $router
 */

$router->group(['prefix' => 'orders'], function (Router $router) {
    $router->get('count', 'OrderController@count');
    $router->group(['prefix' => '{order}'], function (Router $router) {
        $router->post('append', 'OrderController@append');
    });
});
$router->apiResource('orders', 'OrderController', [
    'only' => ['index']
]);
$router->apiResource('tasks', 'TaskController', [
    'only' => ['index', 'edit']
]);
$router->group(['prefix' => 'balance'], function (Router $router) {
    $router->get('', 'BalanceController@index');
    $router->match(['put', 'patch'], '', 'BalanceController@update');
});
$router->group(['prefix' => 'profile'], function (Router $router) {
    $router->match(['put', 'patch'], '', 'ProfileController@update');
    $router->post('password', 'ProfileController@password');
});