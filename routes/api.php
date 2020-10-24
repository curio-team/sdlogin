<?php

// This API works under two domain api.curio.code and (legacy) api.amo.rocks

$apiRoutes = function() {
	
	Route::group(['middleware' => 'auth:api'], function() {

	
	//////////////// USERS API ////////////////
	// All responses (except index) will include the user's full history of groups

		//Return current user		
		Route::get('/me', 'Api\UserApiController@me');

		//Return all users (index), teachers only
		Route::get('/users', 'Api\UserApiController@index');

		//Find a user by id(ab01 / D123456), teachers only			
		Route::get('/users/{user}', 'Api\UserApiController@user');

	
	//////////////// GROUPS API ///////////////
	// All responses (except index) will include the group's members (only for teachers)

	  	//Return all currently active groups (index)
		Route::get('/groups', 'Api\GroupApiController@index');

	  	//Find group by name (eg.: RIO4-AMO1A). Returns only currently active groups!
		Route::get('/groups/find/{name}', 'Api\GroupApiController@find');

		//Find group by id
		Route::get('/groups/{group}', 'Api\GroupApiController@group');

	});

};

Route::group(['domain' => 'api.amo.rocks'], $apiRoutes);
Route::group(['domain' => 'api.curio.codes'], $apiRoutes);
