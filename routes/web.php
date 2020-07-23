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
$router->group(['prefix' => 'api/'], function($app) {
    $app->get('task/view/{id}/', 'TaskController@view');
    $app->get('login/', 'UserController@authenticate');
    $app->post('task/', 'TaskController@store');
    $app->get('task/', 'TaskController@index');
    $app->put('task/{id}/', 'TaskController@update');
    $app->delete('task/{id}/', 'TaskController@delete');

});
