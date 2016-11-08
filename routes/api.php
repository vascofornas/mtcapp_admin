<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
*/

Route::group(['namespace' => 'Api','middleware' => 'cors'], function () {

    /* Why u no restful */
    Route::get('/que-hacer', 'QueHacerController@index');
    Route::get('/que-hacer/concejalia/{id}', 'QueHacerController@concejalia');
    Route::get('/que-hacer/tipo-actividad/{id}', 'QueHacerController@concejalia');
    Route::get('/que-hacer/agenda/{fecha}', 'QueHacerController@agenda');
    Route::get('/que-hacer/detalle/{id}', 'QueHacerController@detalle'); //??

});
