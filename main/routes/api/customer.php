<?php

use Illuminate\Routing\Router;

/**
 * @var Router $router
 */

$router->group(['prefix' => 'projects'], function (Router $router) {
    $router->get('compact', 'ProjectController@compact');
    $router->post('action', 'ProjectController@action');
    $router->group(['prefix' => '{project}/settings'], function (Router $router) {
        $router->get('', 'ProjectSettingController@index');
        $router->group(['prefix' => '{check}'], function (Router $router) {
            $router->post('', 'ProjectSettingController@updateOrCreate');
            $router->delete('', 'ProjectSettingController@destroy');
        });
    });
});
$router->apiResource('projects', 'ProjectController', [
    'only' => ['index', 'store', 'update', 'destroy']
]);
$router->group(['prefix' => 'settings'], function (Router $router) {
    $router->get('', 'SettingController@index');
    $router->group(['prefix' => '{check}'], function (Router $router) {
        $router->post('', 'SettingController@updateOrCreate');
        $router->delete('', 'SettingController@destroy');
    });
});
$router->group(['prefix' => 'orders'], function (Router $router) {
    $router->get('count', 'OrderController@count');
    $router->post('action', 'OrderController@action');
    $router->group(['prefix' => '{order}'], function (Router $router) {
        $router->post('publish', 'OrderController@publish');
        $router->post('rollback', 'OrderController@rollback');
    });
});
$router->apiResource('orders', 'OrderController', [
    'only' => ['index', 'show', 'store', 'update', 'destroy']
]);
$router->group(['prefix' => 'balance'], function (Router $router) {
    $router->get('', 'BalanceController@index');
    $router->match(['put', 'patch'], '', 'BalanceController@update');
    $router->post('withdraw', 'BalanceController@withdraw');
    $router->post('refill', 'BalanceController@refill');
});
$router->group(['prefix' => 'profile'], function (Router $router) {
    $router->match(['put', 'patch'], '', 'ProfileController@update');
    $router->post('password', 'ProfileController@password');
});
