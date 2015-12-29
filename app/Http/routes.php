<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| API routes
|--------------------------------------------------------------------------
*/
Route::group([
    'prefix' => 'api',
    'namespace' => 'Api\{version}',
    'middleware' => ['api.version', 'language', 'paginate']
], function () {
    Route::post('auth', 'AuthJwtController@authenticate');


    Route::post('token-refresh', [
        'middleware' => 'jwt.refresh',
        'uses' => 'AuthJwtController@refresh'
    ]);


    /*
    |--------------------------------------------------------------------------
    | API Auth routes
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::resource('roles', 'RolesController', [
            'only' => ['index', 'show', 'store', 'update', 'destroy']
        ]);


        Route::resource('members', 'MembersController', [
            'only' => ['index', 'show', 'store', 'update', 'destroy']
        ]);


        Route::resource('administrators', 'AdministratorsController', [
            'only' => ['index', 'show', 'store', 'update', 'destroy']
        ]);


        Route::resource('cities', 'CitiesController', [
            'only' => ['index', 'store', 'show', 'update', 'destroy']
        ]);


        Route::resource('countries', 'CountriesController', [
            'only' => ['index', 'store', 'show', 'update', 'destroy']
        ]);


        Route::get('countries/{country_id}/cities', 'CountryCitiesController@index');
    });
});


