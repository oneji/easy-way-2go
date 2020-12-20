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

Route::namespace('API')->group(function() {
    Route::prefix('auth')->group(function() {
        // Client authentication
        Route::post('clients/register', 'ClientAuthController@register');
        
        // User authentication
        Route::post('verify', 'UserController@verify');
        Route::post('login', 'UserController@login');
        Route::get('me', 'UserController@me')->middleware('jwt.verify');
        Route::get('refreshToken', 'UserController@refreshToken')->middleware('jwt.verify');
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

    // Help
    Route::get('help', 'HelpSectionController@all');

    // Driving experiences
    Route::get('drivingExperiences', 'DrivingExperienceController@all');
    // Car brands
    Route::get('carBrands',  'CarBrandController@all');
    // Car models
    Route::get('carModels',  'CarModelController@all');
    Route::get('carModels/getByBrandId/{id}',  'CarModelController@getByBrandId');
    // Cargo types
    Route::get('cargoTypes', 'CargoTypeController@all');
    // Payment methods
    Route::get('paymentMethods', 'PaymentMethodController@all');
    // Payment statuses
    Route::get('paymentStatuses', 'PaymentStatusController@all');
    // Order statuses
    Route::get('orderStatuses', 'OrderStatusController@all');
    // Prices
    Route::get('prices', 'PriceController@all');

    Route::middleware('jwt.verify')->group(function() {
        // Clients
        Route::put('clients/changePassword', 'ClientController@changePassword');
        Route::post('clients/{id}', 'ClientController@update');
        Route::get('clients/checkEmail', 'ClientController@checkEmail');
       
        // Brigadirs
        Route::put('brigadirs/updateCompany/{id}', 'BrigadirController@updateCompany');
        Route::put('brigadirs/changePassword', 'BrigadirController@changePassword');
        Route::post('brigadirs/{id}', 'BrigadirController@updateProfile');
        
        Route::get('brigadirs/orders', 'BrigadirController@getOrders');
        Route::get('brigadirs/orders/getById/{id}', 'BrigadirController@getOrderById');
        Route::delete('brigadirs/orders/detachDriver', 'BrigadirController@detachDriverFromOrder');
        
        Route::get('brigadirs/transport', 'BrigadirController@getTransport');
        
        Route::get('brigadirs/getDriversGroupedByTransport', 'BrigadirController@getDriversGroupedByTransport');
        Route::get('brigadirs/drivers', 'BrigadirController@getDrivers');
        Route::post('brigadirs/drivers/invite', 'BrigadirController@inviteDriver');
        Route::post('brigadirs/drivers/block/{id}', 'BrigadirController@blockDriver');

        // Drivers
        Route::put('drivers/changePassword', 'DriverController@changePassword');
        Route::post('drivers/{id}', 'DriverController@update');
        Route::get('drivers/getOrders', 'DriverController@getOrders');

        // Orders
        Route::get('orders', 'OrderController@all');
        Route::post('orders', 'OrderController@store');
        Route::get('orders/getById/{id}', 'OrderController@getById');
        Route::post('orders/cancel', 'OrderController@cancel');
        Route::put('orders/setNewTransport', 'OrderController@setNewTransport');
        
        // Passengers
        Route::get('passengers', 'PassengerController@all');
        Route::get('passengers/getById/{id}', 'PassengerController@getById');
        Route::post('passengers', 'PassengerController@store');
        Route::put('passengers/{id}', 'PassengerController@update');
        Route::delete('passengers/{id}', 'PassengerController@delete');

        // Bank cards
        Route::get('bankCards', 'BankCardController@all');
        Route::post('bankCards', 'BankCardController@store');

        // Faq
        Route::get('faq', 'FaqController@all');
        Route::get('faq/getById/{id}', 'FaqController@getById');
    });
});