<?php
/**
 * ETML
 * Author : João Ferreira
 * Date : 24.05.2023
 * Description : Routes for the API requests
 */

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

// route to retrieve data from the t_station table, the ID of a specific station can also be choosen : (?idStation=)
$router->get('/stations', 'RequestsController@getStations');

// route to retrieve values from t_values table from last hours, (?hours=), and also returns their average (?average=true) 
$router->get('/values', 'RequestsController@getValues');

// route to retrieve the most recent values from each station, and also option for do their average (?average=true)
$router->get('/values/latest', 'RequestsController@getLatestValuesEachStation');

// route to retrieve all values from a station from last hours, (?hours=),
$router->get('/values/{idStation}', 'RequestsController@getAllValuesByStation');


// route to store new data in the t_values table
$router->post('/store', 'RequestsController@store');