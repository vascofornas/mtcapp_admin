<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::group(['middleware' => 'auth', 'prefix' => '/panel', 'namespace' => 'Panel'], function () {
    Route::get('/', 'IndexController@index');


    /* Mantenimiento */

    Route::get('organizaciones', 'OrganizacionesController@index');
    Route::any('organizaciones/editar/{id}', 'OrganizacionesController@editar');
    Route::get('organizaciones/suborganizaciones', 'OrganizacionesController@suborganizaciones');
    Route::any('organizaciones/suborganizacion/{id}', 'OrganizacionesController@suborganizacion');

    Route::get('concejalias', 'ConcejaliasController@index');
    Route::any('concejalias/editar/{id}', 'ConcejaliasController@editar');

    Route::get('tipos-actividad', 'TiposActividadController@index');
    Route::any('tipos-actividad/editar/{id}', 'TiposActividadController@editar');

    Route::get('tipos-ubicacion', 'TiposUbicacionController@index');
    Route::any('tipos-ubicacion/editar/{id}', 'TiposUbicacionController@editar');

    Route::get('tipos-organizacion', 'TiposOrganizacionController@index');
    Route::any('tipos-organizacion/editar/{id}', 'TiposOrganizacionController@editar');

});


