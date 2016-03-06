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
    'namespace' => 'Api\{version}',
    'middleware' => ['api.version', 'language', 'paginate']
], function () {
    Route::post('auth', 'AuthJwtController@authenticate');


    Route::post('token-refresh', [
        'middleware' => 'jwt.refresh',
        'uses' => 'AuthJwtController@refresh'
    ]);

    Route::resource('categories', 'CategoriesController', [
        'only' => ['index', 'show']
    ]);

    Route::get('categories/{category_id}/images', 'CategoryImagesController@index');

    /*
    |--------------------------------------------------------------------------
    | API Auth routes
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::get('users/me', 'AuthJwtController@me');


        Route::post('categories', 'CategoriesController@store');
        Route::post('categories/{category_id}', 'CategoriesController@update');
        Route::delete('categories/{category_id}', 'CategoriesController@destroy');


        Route::post('categories/{category_id}/images', 'CategoryImagesController@store');
        Route::delete('categories/{category_id}/images/{image_id}', 'CategoryImagesController@destroy');
    });
});

use Illuminate\Support\Facades\Artisan;

Route::get('migrate', function () {
    Artisan::call('migrate:refresh');
    echo 'migrated';

    Artisan::call('db:seed');
    echo 'seeded';
});
