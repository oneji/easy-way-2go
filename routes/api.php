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

// Auth
Route::as('api.')->namespace('API')->group(function() {
    Route::prefix('auth')->group(function() {
        // Client authentication
        Route::post('clients/register', 'ClientAuthController@register');
        
        // Driver authentication
        Route::post('drivers/register', 'DriverAuthController@register');
        
        // Brigadir authentication
        Route::post('brigadirs/register', 'BrigadirAuthController@register');
        
        // User authentication
        Route::get('verify/{code}', 'UserController@verify');
        Route::post('login', 'UserController@login');
    });

    // Driver routes
    Route::post('routes', 'RouteController@store')->middleware('jwt.verify');

    // Transport
    Route::post('transport', 'TransportController@store');
    Route::put('transport/{id}', 'TransportController@update');
    Route::post('transport/bindDriver', 'TransportController@bindDriver');
});