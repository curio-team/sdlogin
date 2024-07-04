<?php

use Illuminate\Support\Facades\Route;

$apiRoutes = function () {
    Route::group(['middleware' => 'auth:api'], function () {
        /**
         * Users API
         */

        // All responses (except index) will include the user's full history of groups

        //Return current user
        Route::get('/me', [App\Http\Controllers\Api\UserApiController::class, 'me']);

        //Return all users (index), teachers only
        Route::get('/users', [App\Http\Controllers\Api\UserApiController::class, 'index']);

        //Find a user by id(ab01 / D123456), teachers only
        Route::get('/users/{user}', [App\Http\Controllers\Api\UserApiController::class, 'user']);

        /**
         * Groups API
         */

        // All responses (except index) will include the group's members (only for teachers)

        //Return all currently active groups (index)
        Route::get('/groups', [App\Http\Controllers\Api\GroupApiController::class, 'index'])->name('api.groups');

        //Find group by name (eg.: RIO4-AMO1A). Returns only currently active groups!
        Route::get('/groups/find/{name}', [App\Http\Controllers\Api\GroupApiController::class, 'find'])->name('api.groups.find');

        //Find group by id
        Route::get('/groups/{group}', [App\Http\Controllers\Api\GroupApiController::class, 'group'])->name('api.groups.group');
    });
};

if (env('APP_ENV') === 'local' || env('APP_ENV') === 'testing') {
    Route::group([], $apiRoutes);
} else {
    Route::group(['domain' => 'api.curio.codes'], $apiRoutes);
}
