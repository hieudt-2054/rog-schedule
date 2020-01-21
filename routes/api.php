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
    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });
});