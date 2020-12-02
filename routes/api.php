<?php

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
Route::namespace('API')->group(function() {
    Route::prefix('auth')->group(function() {
        // Client authentication
        Route::post('clients/register', 'ClientAuthController@register');
        
        // Driver authentication
        Route::post('drivers/register', 'DriverAuthController@register');
        
        // Brigadir authentication
        Route::post('brigadirs/register', 'BrigadirAuthController@register');
        
        // User authentication
        Route::post('verify', 'UserController@verify');
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

    // Countries
    Route::get('countries', 'CountryController@all');

    Route::middleware('jwt.verify')->group(function() {
        // Clients
        Route::put('clients/changePassword', 'ClientController@changePassword');
        Route::put('clients/{id}', 'ClientController@update');
        Route::get('clients/checkEmail', 'ClientController@checkEmail');

        // Orders
        Route::get('orders', 'OrderController@all');
        Route::post('orders', 'OrderController@store');
        
        // Passengers
        Route::get('passengers', 'PassengerController@all');
        Route::post('passengers', 'PassengerController@store');
        Route::put('passengers/{id}', 'PassengerController@update');
        Route::delete('passengers/{id}', 'PassengerController@delete');

        // Driving experiences
        Route::get('driving-experiences', 'DrivingExperienceController@all');
        // Car brands
        Route::get('car-brands',  'CarBrandController@all');
        // Car models
        Route::get('car-models',  'CarModelController@all');
        Route::get('car-models/getByBrandId/{id}',  'CarModelController@getByBrandId');

        // Bank cards
        Route::get('bankCards', 'BankCardController@all');
        Route::post('bankCards', 'BankCardController@store');
    });
});