<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('/kids');
});


Route::group([
    'middleware' => ['auth', 'twofactor']
], function () {
    Route::resource('/kids', 'KidController');
    Route::post('/kids/list','KidController@list');

    Route::resource('/classrooms', 'ClassroomController');
    Route::post('/classrooms/list','ClassroomController@list');

    Route::resource('/payments', 'PaymentController');
    Route::post('/payments/list','PaymentController@list');
});

Route::get('verify/resend', 'Auth\TwoFactorController@resend')->name('verify.resend');
Route::resource('verify', 'Auth\TwoFactorController')->only(['index', 'store']);

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');
Route::group( [ 'middleware' => 'admin'], function () {
    Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
});







