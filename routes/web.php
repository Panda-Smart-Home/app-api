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

$router->get('/devices[/{id}]', 'DeviceController@get');
$router->patch('/devices/{id}', 'DeviceController@update');

$router->get('/scenes[/{id}]', 'SceneController@get');
$router->post('/scenes', 'SceneController@create');
$router->patch('/scenes/{id}', 'SceneController@update');
$router->delete('/scenes/{id}', 'SceneController@delete');
