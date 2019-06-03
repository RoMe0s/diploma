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
        'prefix' => 'customer',
        'namespace' => 'Customer',
        'middleware' => 'roles:' . Role::CUSTOMER
    ], base_path('routes/api/customer.php'));
    $router->group([
        'prefix' => 'author',
        'namespace' => 'Author',
        'middleware' => 'roles:' . Role::AUTHOR
    ], base_path('routes/api/author.php'));
});
