<?php

use Illuminate\Support\Facades\Route;

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


Route::group(['prefix'=>'/api','middleware' => 'auth'], function(){
    Route::post('/FormDefinition', 'FormsController@createForm');
    Route::get('/FormDefinition/{}/{}', 'FormsController@getFormsByID');
    Route::get('/FormDefinition/{clientId}', 'FormsController@getAllForms');
    Route::post('/FormDefinition/{formId}', 'FormsController@updateForm');
//    Route::post('/FormDefinition/{formId}', 'FormsController@disableForm');
    Route::delete('/FormDefinition/{formId}', 'FormsController@delete');


});

