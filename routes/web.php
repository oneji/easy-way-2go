<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('emails', function() {
//     $code = 123123;
//     $email = 'test@gmail.com';
//     $password = 'testPassword';

//     return view('emails.register', [
//         'code' => $code,
//         'email' => $email,
//         'password' => $password
//     ]);
// });

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
], function() {
    // Localization
    Route::get('lang/{lang}', 'LocalizationController@switchLanguage')->name('lang.switch');
    
    Auth::routes();
    
    Route::get('/', 'HomeController@index')->name('home');
    
    Route::as('admin.')->middleware('auth')->group(function() {
        Route::resource('brigadirs', 'BrigadirController')->except([ 'destroy' ]);
        Route::resource('drivers', 'DriverController')->except([ 'destroy' ]);
        Route::resource('clients', 'ClientController')->except([ 'destroy' ]);
        Route::resource('transport', 'TransportController')->except([ 'destroy' ]);
    
        // Drivers
        Route::get('drivers/{driverId}/destroyDoc/{docId}', 'DriverController@destroyDoc')->name('drivers.destroyDoc');
        
        // Transport
        Route::get('transport/destroyDoc/{id}', 'TransportController@destroyDoc')->name('transport.destroyDoc');
        Route::post('transport/bindDriver', 'TransportController@bindDriver')->name('transport.bindDriver');
    
        // Driving experience
        Route::get('driving-experience', 'DrivingExperienceController@index')->name('de.index');
        Route::get('driving-experience/getById/{id}', 'DrivingExperienceController@getById')->name('de.getById');
        Route::post('driving-experience', 'DrivingExperienceController@store')->name('de.store');
        Route::put('driving-experience/{id}', 'DrivingExperienceController@update')->name('de.update');
        
        // Languages
        Route::get('languages', 'LanguageController@index')->name('languages.index');
        Route::get('languages/getById/{id}', 'LanguageController@getById')->name('languages.getById');
        Route::post('languages', 'LanguageController@store')->name('languages.store');
        Route::put('languages/{id}', 'LanguageController@update')->name('languages.update');

        // Languages
        Route::get('countries', 'CountryController@index')->name('countries.index');
        Route::get('countries/getById/{id}', 'CountryController@getById')->name('countries.getById');
        Route::post('countries', 'CountryController@store')->name('countries.store');
        Route::put('countries/{id}', 'CountryController@update')->name('countries.update');
    
        // Car brands
        Route::get('car-brands', 'CarBrandController@index')->name('carBrands.index');
        Route::get('car-brands/getById/{id}', 'CarBrandController@getById')->name('carBrands.getById');
        Route::post('car-brands', 'CarBrandController@store')->name('carBrands.store');
        Route::put('car-brands/{id}', 'CarBrandController@update')->name('carBrands.update');
        
        // Car models
        Route::get('car-models', 'CarModelController@index')->name('carModels.index');
        Route::get('car-models/getById/{id}', 'CarModelController@getById')->name('carModels.getById');
        Route::post('car-models', 'CarModelController@store')->name('carModels.store');
        Route::put('car-models/{id}', 'CarModelController@update')->name('carModels.update');

        // Cargo types
        Route::get('cargo-types', 'CargoTypeController@index')->name('cargoTypes.index');
        Route::get('cargo-types/getById/{id}', 'CargoTypeController@getById')->name('cargoTypes.getById');
        Route::post('cargo-types', 'CargoTypeController@store')->name('cargoTypes.store');
        Route::put('cargo-types/{id}', 'CargoTypeController@update')->name('cargoTypes.update');
        
        // Routes
        Route::get('routes', 'RouteController@index')->name('routes.index');
        Route::get('routes/create', 'RouteController@create')->name('routes.create');

        // Bussiness account requests
        Route::get('bas', 'BaRequestController@index')->name('bas.index');
        Route::get('bas/{id}', 'BaRequestController@show')->name('bas.show');
        Route::post('bas/{id}/approve', 'BaRequestController@approve')->name('bas.approve');
        Route::post('bas/{id}/decline', 'BaRequestController@decline')->name('bas.decline');

        // Orders
        Route::get('orders', 'OrderController@index')->name('orders.index');
        Route::get('orders/{id}', 'OrderController@show')->name('orders.show');

        // Faq
        Route::get('faq', 'FaqController@index')->name('faq.index');
        Route::get('faq/create', 'FaqController@create')->name('faq.create');
        Route::post('faq', 'FaqController@store')->name('faq.store');
        Route::get('faq/edit/{id}', 'FaqController@edit')->name('faq.edit');
        Route::put('faq/{id}', 'FaqController@update')->name('faq.update');
        Route::delete('faq/{id}', 'FaqController@delete')->name('faq.delete');
        
        // Help
        Route::get('help', 'HelpSectionController@index')->name('help.index');
        Route::post('help', 'HelpSectionController@store')->name('help.store');
        Route::put('help/{id}', 'HelpSectionController@update')->name('help.update');
        Route::delete('help/{id}', 'HelpSectionController@delete')->name('help.delete');
        Route::get('help/getById/{id}', 'HelpSectionController@getById')->name('help.getById');
        
        // Help items
        Route::post('help-items', 'HelpItemController@store')->name('helpItems.store');
        Route::put('help-items/{id}', 'HelpItemController@update')->name('helpItems.update');
        Route::get('help-items/create', 'HelpItemController@create')->name('helpItems.create');
        Route::get('help-items/edit/{id}', 'HelpItemController@edit')->name('helpItems.edit');

        // Payment methods
        Route::get('payment-methods', 'PaymentMethodController@index')->name('paymentMethods.index');
        Route::post('payment-methods', 'PaymentMethodController@store')->name('paymentMethods.store');
        Route::put('payment-methods/{id}', 'PaymentMethodController@update')->name('paymentMethods.update');
        Route::delete('payment-methods/{id}', 'PaymentMethodController@delete')->name('paymentMethods.delete');
        Route::get('payment-methods/getById/{id}', 'PaymentMethodController@getById')->name('paymentMethods.getById');

        // Payment statuses
        Route::get('payment-statuses', 'PaymentStatusController@index')->name('paymentStatuses.index');
        Route::get('payment-statuses/getById/{id}', 'PaymentStatusController@getById')->name('paymentStatuses.getById');
        Route::post('payment-statuses', 'PaymentStatusController@store')->name('paymentStatuses.store');
        Route::put('payment-statuses/{id}', 'PaymentStatusController@update')->name('paymentStatuses.update');
        
        // Order statuses
        Route::get('order-statuses', 'OrderStatusController@index')->name('orderStatuses.index');
        Route::get('order-statuses/getById/{id}', 'OrderStatusController@getById')->name('orderStatuses.getById');
        Route::post('order-statuses', 'OrderStatusController@store')->name('orderStatuses.store');
        Route::put('order-statuses/{id}', 'OrderStatusController@update')->name('orderStatuses.update');
        
        // Prices
        Route::get('prices', 'PriceController@index')->name('prices.index');
        Route::get('prices/getById/{id}', 'PriceController@getById')->name('prices.getById');
        Route::post('prices', 'PriceController@store')->name('prices.store');
        Route::put('prices/{id}', 'PriceController@update')->name('prices.update');

        // Chat
        Route::get('chat', function() {
            return view('chat.index');
        });
    });
});

