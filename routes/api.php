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

use Illuminate\Support\Facades\Route;

Route::namespace('API')->group(function() {
    Route::prefix('auth')->group(function() {
        // Client authentication
        Route::post('clients/register', 'ClientController@register');
        
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

    // Routes
    Route::post('routes', 'RouteController@store');
    Route::get('routes/getById/{id}', 'RouteController@getById');
    Route::get('routes/search', 'RouteController@search');
    Route::put('routes/archive/{id}', 'RouteController@archive');

    // Business account requests
    Route::post('baRequests', 'BaRequestController@store');
    Route::get('baRequests/getById/{id}', 'BaRequestController@getById');

    Route::get('countries', 'CountryController@all');
    Route::get('help', 'HelpSectionController@all');
    Route::get('drivingExperiences', 'DrivingExperienceController@all');
    Route::get('carBrands',  'CarBrandController@all');
    Route::get('carModels',  'CarModelController@all');
    Route::get('carModels/getByBrandId/{id}',  'CarModelController@getByBrandId');
    Route::get('cargoTypes', 'CargoTypeController@all');
    Route::get('paymentMethods', 'PaymentMethodController@all');
    Route::get('paymentStatuses', 'PaymentStatusController@all');
    Route::get('orderStatuses', 'OrderStatusController@all');
    Route::get('prices', 'PriceController@all');

    Route::middleware('jwt.verify')->group(function() {
        // Clients
        Route::put('clients/changePassword', 'ClientController@changePassword');
        Route::post('clients/{id}', 'ClientController@update');
        Route::get('clients/checkEmail', 'ClientController@checkEmail');
        Route::get('clients/orders', 'ClientController@getOrders');
       
        // Brigadirs
        Route::put('brigadirs/updateCompany/{id}', 'BrigadirController@updateCompany');
        Route::put('brigadirs/changePassword', 'BrigadirController@changePassword');
        Route::post('brigadirs/{id}', 'BrigadirController@updateProfile');
        
        Route::get('brigadirs/trips', 'BrigadirController@getTrips');
        Route::get('brigadirs/trips/finished', 'BrigadirController@getFinishedTrips');
        Route::get('brigadirs/trips/getById/{id}', 'BrigadirController@getTripById');

        Route::delete('brigadirs/orders/detachDriver', 'BrigadirController@detachDriverFromOrder');
        Route::post('brigadirs/orders/attachDriver', 'BrigadirController@attachDriverToOrder');
        
        Route::get('brigadirs/transport', 'BrigadirController@getTransport');
        Route::get('brigadirs/transportWithOnlyCarNumber', 'BrigadirController@getTransportWithOnlyCarNumber');
        
        Route::get('brigadirs/getDriversGroupedByTransport', 'BrigadirController@getDriversGroupedByTransport');
        Route::get('brigadirs/drivers', 'BrigadirController@getDrivers');
        Route::post('brigadirs/drivers/invite', 'BrigadirController@inviteDriver');
        Route::post('brigadirs/drivers/block/{id}', 'BrigadirController@blockDriver');
        Route::get('brigadirs/drivers/getById/{id}', 'BrigadirController@getDriverById');
        Route::get('brigadirs/drivers/getTransport/{id}', 'BrigadirController@getDriversTransport');
        Route::put('brigadirs/drivers/changePassword/{id}', 'BrigadirController@changeDriversPassword');

        Route::get('brigadirs/routes', 'BrigadirController@getRoutes');
        Route::get('brigadirs/routes/archived', 'BrigadirController@getArchivedRoutes');

        // Drivers
        Route::put('drivers/changePassword', 'DriverController@changePassword');
        Route::post('drivers/{id}', 'DriverController@update');
        Route::get('drivers/trips', 'DriverController@getTrips');
        Route::get('drivers/trips/finished', 'DriverController@getFinishedTrips');
        Route::get('drivers/getRoutes', 'DriverController@getRoutes');
        Route::get('drivers/getArchivedRoutes', 'DriverController@getArchivedRoutes');

        // Orders
        Route::post('orders', 'OrderController@store');
        Route::get('orders/getById/{id}', 'OrderController@getById');
        Route::get('orders/getByIdFromChat/{id}', 'OrderController@getByIdFromChat');
        Route::post('orders/cancel', 'OrderController@cancel');
        Route::post('orders/approve/{id}', 'OrderController@approve');

        // Trips
        Route::post('trips/setDriver', 'TripController@setDriver');
        Route::post('trips/setNewTransport', 'TripController@setNewTransport');
        Route::post('trips/cancel', 'TripController@cancel');
        Route::post('trips/finishHalf/{id}', 'TripController@finishHalf');
        Route::post('trips/changeDirection', 'TripController@changeDirection');
        Route::post('trips/startBoarding/{id}', 'TripController@startBoarding');
        Route::get('trips/getOrdersToStartBoarding/{id}', 'TripController@getOrdersToStartBoarding');
        Route::post('trips/finishBoarding/{id}', 'TripController@finishBoarding');
        
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
        
        // Debts
        Route::get('debts', 'DebtController@all');
        Route::post('debts/approve/{id}', 'DebtController@approve');

        // Balance
        Route::get('balance', 'BalanceController@all');

        // Statistics
        Route::get('statistics', 'StatsController@getTotal');
        Route::get('statistics/getByBus', 'StatsController@getByBus');
    });
});