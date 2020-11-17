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
    Route::post('routes', 'RouteController@store');

    // Transport
    Route::post('transport', 'TransportController@store');
    Route::put('transport/{id}', 'TransportController@update');
    Route::post('transport/bindDriver', 'TransportController@bindDriver');

    // Routes
    Route::get('routes/getById/{id}', 'RouteController@getById');
    Route::get('routes/search', 'RouteController@search');

    // Business account requests
    Route::post('baRequests', 'BaRequestController@store');
    Route::get('baRequests/getById/{id}', 'BaRequestController@getById');

    Route::middleware('jwt.verify')->group(function() {
        // Orders
        Route::post('orders', 'OrderController@store');
        
        // Passengers
        Route::get('passengers', 'PassengerController@all');
        Route::post('passengers', 'PassengerController@store');
        Route::put('passengers/{id}', 'PassengerController@update');
    });
});