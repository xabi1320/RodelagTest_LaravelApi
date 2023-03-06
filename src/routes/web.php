<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(["prefix" => "/v1"], function() use ($router)
{
    $router->group(["prefix" => "/user"], function() use ($router)
    {
        $router->get('/list', 'UserController@getListUser');
        $router->post('/register', 'UserController@createUser');
        $router->patch('/{id}', 'UserController@patchUser');
        $router->delete('/{id}', 'UserController@deleteUser');
        $router->get('/{id}/restore', 'UserController@restoreUser');
    });

    $router->group(["prefix" => "/episode"], function() use ($router)
    {
        $router->get('/list', 'EpisodeController@getListEpisodes');
        $router->post('/', 'EpisodeController@createEpisode');
        $router->patch('/{id}', 'EpisodeController@patchEpisode');
        $router->delete('/{id}', 'EpisodeController@deleteEpisode');
        $router->get('/{id}/restore', 'EpisodeController@restoreEpisode');
    });
});
