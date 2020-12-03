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
        Route::post('drivers/register', 'DriverAuthController@register');        
        Route::post('brigadirs/register', 'BrigadirAuthController@register');
        
        // User authentication
        Route::post('verify', 'UserController@verify');
        Route::post('login', 'UserController@login');
        Route::get('me', 'UserController@me')->middleware('jwt.verify');
    });

    // Transport
    Route::post('transport', 'TransportController@store');
    Route::put('transport/{id}', 'TransportController@update');
    Route::post('transport/bindDriver', 'TransportController@bindDriver');
    // Transport routes
    Route::post('routes', 'RouteController@store');

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
       
        // Brigadirs
        Route::put('brigadirs/changePassword', 'BrigadirController@changePassword');
        Route::put('brigadirs/{id}', 'BrigadirController@updateProfile');
        Route::put('brigadirs/updateCompany/{id}', 'BrigadirController@updateCompany');

        // Orders
        Route::get('orders', 'OrderController@all');
        Route::post('orders', 'OrderController@store');
        
        // Passengers
        Route::get('passengers', 'PassengerController@all');
        Route::post('passengers', 'PassengerController@store');
        Route::put('passengers/{id}', 'PassengerController@update');
        Route::delete('passengers/{id}', 'PassengerController@delete');

        // Driving experiences
        Route::get('drivingExperiences', 'DrivingExperienceController@all');
        // Car brands
        Route::get('carBrands',  'CarBrandController@all');
        // Car models
        Route::get('carModels',  'CarModelController@all');
        Route::get('carModels/getByBrandId/{id}',  'CarModelController@getByBrandId');

        // Bank cards
        Route::get('bankCards', 'BankCardController@all');
        Route::post('bankCards', 'BankCardController@store');

        // Cargo types
        Route::get('cargoTypes', 'CargoTypeController@all');
    });
});