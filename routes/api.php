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

Route::group(['middleware' => ['json.response']], function () {
    // Public Routes
    Route::post('/register', 'AuthController@store')->name('register.api');
    Route::post('/login', 'AuthController@login')->name('login.api');
    // Private routes
    Route::middleware('auth:api')->group(function () {
        // Auth routes.
        Route::post('/logout', 'AuthController@logout')->name('logout.api');
        Route::get('/schedule', 'ScheduleController@getAll')->name('schedule.getall');
        Route::post('/generate2FA', 'PasswordSecurityController@generate2faSecret')->name('2fa.generate');
        Route::get('/get2FA', 'PasswordSecurityController@show2fa')->name('2fa.data');
        Route::post('/enable2FA', 'PasswordSecurityController@enable2fa')->name('2fa.enable');
        // Standard Routes
        Route::resource('/schedule', 'ScheduleController', ['except' => ['create', 'edit', 'index']]);
    });
});
