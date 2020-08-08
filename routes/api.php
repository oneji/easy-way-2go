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
        Route::post('clients/register', 'ClientAuthController@register')->name('registerClient');
        
        // Driver authentication
        Route::post('drivers/register', 'DriverAuthController@register')->name('registerDriver');
        
        // Brigadir authentication
        Route::post('brigadirs/register', 'BrigadirAuthController@register')->name('registerBrigadir');
        
        // User authentication
        Route::get('verify/{code}', 'UserController@verify')->name('verifyUser');
        Route::post('login', 'UserController@login')->name('loginUser');
    });
});