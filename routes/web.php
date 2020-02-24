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
/* Routes Test Services */
Route::get('exc', function () {
    Log::debug('Exception Sentry Test');
    throw new Exception('Nothing');
});

Route::get('/2fa','PasswordSecurityController@show2faForm');
Route::post('/generate2faSecret','PasswordSecurityController@generate2faSecret')->name('generate2faSecret');
Route::post('/2fa','PasswordSecurityController@enable2fa')->name('enable2fa');
Route::post('/disable2fa','PasswordSecurityController@disable2fa')->name('disable2fa');

Route::post('sociallogin/{provider}', 'AuthController@socialLogin');
Route::post('auth/{provider}', 'AuthController@index')->where('vue', '.*');
Route::post('auth/{provider}/callback', 'AuthController@index')->where('vue', '.*');

Route::get('{path}', function () {
    return view('index');
})->where('path', '(.*)');

