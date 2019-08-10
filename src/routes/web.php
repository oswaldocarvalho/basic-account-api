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

$router->group(['prefix' => '/'], function () use ($router) {

    $router->get('/', function () use ($router) {
        return $router->app->version();
    });

    $router->group(['prefix' => '/account'], function () use ($router) {
        $router->post('/register', 'AccountController@register');
        $router->post('/sign-in', 'AccountController@signIn');
        $router->delete('/sign-out', ['uses' => 'AccountController@signOut', 'middleware' => 'auth']);
    });

    $router->group(['prefix' => '/ranking', 'middleware' => 'auth'], function () use ($router) {
        $router->get('/', 'RankingController@index');
        $router->patch('/', 'RankingController@insertOrUpdate');
    });
});