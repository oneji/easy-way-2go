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
