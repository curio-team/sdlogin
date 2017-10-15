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

Route::redirect('/', '/me', 301);
Route::get('/me', 'DashboardController@show')->name('home');

Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');