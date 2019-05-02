<?php

use App\Constants\Role;
use Illuminate\Routing\Router;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * @var Router $router
 */

$router->group(['prefix' => 'auth', 'namespace' => 'Auth'], function (Router $router) {
    $router->get('user', 'LoginController@user');
    $router->post('login', 'LoginController@login');
    $router->post('logout', 'LoginController@logout');
    $router->post('register', 'RegisterController@register');
});

$router->group(['middleware' => 'auth'], function (Router $router) {
    $router->group([
        'namespace' => 'Customer',
        'middleware' => 'roles:' . Role::CUSTOMER
    ], function (Router $router) {
        $router->post('projects/action', 'ProjectController@action'); //TODO: add name
        $router->apiResource('projects', 'ProjectController', [
            'only' => ['index', 'store', 'update', 'destroy']
        ]);
    });
});