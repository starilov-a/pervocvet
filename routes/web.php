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

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');
Route::group( [ 'middleware' => 'admin'], function () {
    Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
});

Route::get('/kids', 'KidController@index');
Route::post('/kids/store', 'KidController@store');
Route::get('/kids/{kid}', 'KidController@show');
Route::delete('/kids/{kid}', 'KidController@destroy');
Route::patch('/kids/update/{kid}', 'KidController@update');

Route::get('/payments', 'PaymentController@index');
Route::get('/payments/{payment}', 'PaymentController@show');

Route::post('/ajax/store', 'AjaxController@store');
Route::patch('/ajax/update', 'AjaxController@update');
Route::delete('/ajax/destroy', 'AjaxController@destroy');
Route::post('/ajax/list', 'AjaxController@list');





