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

Route::get('/users', 'UserController@index');
Route::get('/users/create', 'UserController@create');
Route::post('/users', 'UserController@store');
Route::get('/users/{user}/edit', 'UserController@edit');
Route::get('/users/{user}/profile', 'UserController@profile');
Route::patch('/users/{user}/profile', 'UserController@profile_update');
Route::patch('/users/{user}', 'UserController@update');

Route::get('/clients', 'MyClientController@index');
Route::post('/clients', 'MyClientController@store');
Route::get('/clients/create', 'MyClientController@create');
Route::get('/clients/{client}', 'MyClientController@show');
Route::get('/clients/{client}/delete', 'MyClientController@delete');
Route::delete('/clients/{client}', 'MyClientController@destroy');

Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');