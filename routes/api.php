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
    // Client authentication
    Route::post('auth/clients/register', 'ClientAuthController@register')->name('registerClient');
    Route::get('auth/verify/{code}', 'ClientAuthController@verify')->name('verifyClient');
});