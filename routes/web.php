<?php
use Illuminate\Support\Facades\Route;

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
   // return view('home');
    return $router->app->version();
}); 

 $router->group(['prefix'=>'api/v2'], function () use ($router) {
    $router->get('/newrates', 'LatestRatesController@getdata'); 
    $router->get('/betweendates/{from}/{to}', 'RatesWithDatesController@getbetweendates');
    $router->get('/yesterday', 'RatesWithDatesController@getyesterday');
    $router->get('/currentrate/{currencycode}', 'LatestRatesController@getonecurrentrate');
    
 }); 


