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

Route::group(['domain' => 'api.amo.rocks'], function() {
	
	Route::group(['middleware' => 'auth:api'], function() {

		Route::get('/me', 'Api\UserApiController@me');
		Route::get('/users/{user}', 'Api\UserApiController@user');
		Route::get('/groups/find/{name}', 'Api\GroupApiController@find');
		Route::get('/groups/{group}', 'Api\GroupApiController@group');

	});

});
