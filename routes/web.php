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

    // Driving experience
    Route::get('driving-experience', 'DrivingExperienceController@index')->name('de.index');
    Route::post('driving-experience', 'DrivingExperienceController@store')->name('de.store');
});
