<?php

use App\Constants\Role;
use Illuminate\Routing\Router;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * @var Router $router
 */

$router->view('login', 'auth.login')->middleware('guest')->name('login');
$router->view('register', 'auth.register')->middleware('guest')->name('register');

$router->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$router->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$router->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$router->post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

$router->get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
$router->get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
$router->get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

$router->group(['prefix' => 'js'], function (Router $router) {
    $router->get('lang.js', 'StaticController@langJs');
});


$router->group(['middleware' => 'auth'], function (Router $router) {
    $router->view('', 'global.balance');
    $router->view('profile', 'global.profile');
    $router->view('orders', 'global.orders');
    $router->group([
        'namespace' => 'Customer',
        'middleware' => 'roles:' . Role::CUSTOMER
    ], function (Router $router) {
        $router->get('settings', 'SettingController@index');
        $router->group(['prefix' => 'projects/{project}/settings'], function (Router $router) {
            $router->get('', 'ProjectSettingController@index');
        });
        $router->resource('projects', 'ProjectController', [
            'only' => ['index', 'create', 'edit']
        ]);
        $router->resource('orders', 'OrderController', [
            'only' => ['create', 'edit']
        ]);
        $router->resource('checks', 'TaskController', [
            'parameters' => ['checks' => 'task'],
            'only' => ['index', 'show']
        ]);
    });
    $router->group([
        'namespace' => 'Author',
        'middleware' => 'roles:' . Role::AUTHOR
    ], function (Router $router) {
        $router->group(['prefix' => 'tasks'], function (Router $router) {
            $router->get('done', 'TaskController@done');
        });
        $router->resource('tasks', 'TaskController', [
            'only' => ['index', 'edit']
        ]);
    });
});
