<?php

use Laravel\Lumen\Routing\Router;

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

/**
 * @var Router $router
 */
$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('api/login', 'TokenController@generateToken');
$router->post('api/validateToken', 'TokenController@validateToken');

$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {

    $router->group(['prefix' => 'chamados'], function () use ($router) {
        $router->get('', 'CallController@index');
        $router->get('/{id}', 'CallController@show');
        $router->post('', 'CallController@store');
        $router->put('/{id}', 'CallController@update');
        $router->delete('/{id}', 'CallController@destroy');
    });

    $router->group(['prefix' => 'equipes'], function () use ($router) {
        $router->get('', 'TeamController@index');
        $router->get('/{id}', 'TeamController@show');
        $router->post('', 'TeamController@store');
        $router->put('/{id}', 'TeamController@update');
        $router->delete('/{id}', 'TeamController@destroy');
    });

    $router->group(['prefix' => 'agendamentos'], function () use ($router) {
        $router->get('', 'ScheduleController@index');
        $router->get('/{id}', 'ScheduleController@show');
        $router->post('', 'ScheduleController@store');
        $router->put('/{id}', 'ScheduleController@update');
        $router->delete('/{id}', 'ScheduleController@destroy');
    });

    $router->group(['prefix' => 'usuarios'], function () use ($router) {
        $router->get('', 'UserController@index');
        $router->get('/{id}', 'UserController@show');
        $router->post('', 'UserController@store');
        $router->put('/{id}', 'UserController@update');
        $router->delete('/{id}', 'UserController@destroy');
        $router->get('/{id}/chamados', 'CallController@searchByUser');
    });

    $router->get('clientes', 'UserController@clients');

    $router->get("/stats", function () {
        return [
            'chamados' => App\Call::all()->count(),
            'agendamentos' => App\Schedule::all()->count(),
            'equipes' => App\Team::all()->count()
        ];
    });
});
