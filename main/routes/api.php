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
        'prefix' => 'config',
        'namespace' => 'Config'
    ], function (Router $router) {
        $router->get('plan', 'PlanController@index');
    });
    $router->group([
        'namespace' => 'Customer',
        'middleware' => 'roles:' . Role::CUSTOMER
    ], function (Router $router) {
        $router->group(['prefix' => 'projects'], function (Router $router) {
            $router->get('compact', 'ProjectController@compact');
            $router->post('action', 'ProjectController@action')->name('projects.action');
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
        $router->apiResource('orders', 'OrderController', [
            'only' => ['index', 'store']
        ]);
    });
});