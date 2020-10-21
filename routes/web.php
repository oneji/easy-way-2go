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
        
        // Car models`
        Route::get('car-models', 'CarModelController@index')->name('carModels.index');
        Route::get('car-models/getById/{id}', 'CarModelController@getById')->name('carModels.getById');
        Route::post('car-models', 'CarModelController@store')->name('carModels.store');
        Route::put('car-models/{id}', 'CarModelController@update')->name('carModels.update');
    });
});

