<?php

use Illuminate\Routing\Router;

/**
 * @var Router $router
 */

$router->post('{task}', 'CheckController@save');
