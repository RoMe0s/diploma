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

$router->get('js/lang.js', 'StaticController@langJs');

$router->view('', 'home'); //TODO

$router->group(['middleware' => 'auth'], function (Router $router) {
    $router->group([
        'namespace' => 'Customer',
        'middleware' => 'roles:' . Role::CUSTOMER
    ], function (Router $router) {
        $router->resource('projects', 'ProjectController', [
            'only' => ['index', 'create', 'edit']
        ]);
    });
});