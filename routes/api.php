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
        Route::post('clients/login', 'ClientAuthController@login')->name('loginClient');
        Route::post('clients/register', 'ClientAuthController@register')->name('registerClient');
        Route::get('verify/{code}', 'ClientAuthController@verify')->name('verifyClient');
        
        // Driver authentication
        Route::post('drivers/login', 'DriverAuthController@login')->name('loginDriver');
        Route::post('drivers/register', 'DriverAuthController@register')->name('registerDriver');
        
        // Brigadir authentication
        Route::post('brigadirs/login', 'BrigadirAuthController@login')->name('loginBrigadir');
        Route::post('brigadirs/register', 'BrigadirAuthController@register')->name('registerBrigadir');
    });
});