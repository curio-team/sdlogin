<?php

use App\Http\Controllers\BatchGroupController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ImportEolController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\GroupLoginController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\UserCleanupController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

$apiRoutes = function () {
    Route::redirect('/', 'https://apitest.curio.codes/');
};

$mainRoutes = function () {
    Route::redirect('/', 'https://login.curio.codes/');
    Route::get('/{link}', [RedirectController::class, 'go']);
};

$loginRoutes = function () {
    Route::group(['middleware' => [
        'auth',
        \App\Http\Middleware\CheckPasswordForceChange::class,
    ]], function () {
        Route::redirect('/', '/me');
        Route::redirect('/home', '/me');
        Route::get('/me', [DashboardController::class, 'show'])->name('home');

        Route::get('/users/{user}/profile', [UserController::class, 'profile'])->name('users.profile');
        Route::patch('/users/{user}/profile', [UserController::class, 'profileUpdate'])->name('users.profile_update');

        Route::group(['middleware' => \App\Http\Middleware\Admin::class], function () {
            Route::resource('clients', ClientController::class, ['except' => ['edit', 'update']]);
            Route::get('clients/{client}/delete', [ClientController::class, 'delete'])->name('clients.delete');
            Route::get('clients/{client}/toggle', [ClientController::class, 'toggleDev'])->name('clients.toggle-dev');
            Route::post('clients/{client}/change-name', [ClientController::class, 'changeName'])->name('clients.change-name');

            Route::get('groups/create/batch', [BatchGroupController::class, 'create']);
            Route::post('groups/batch', [BatchGroupController::class, 'store']);
            Route::get('groups/{group}/delete', [GroupController::class, 'delete'])->name('groups.delete');
            Route::resource('groups', GroupController::class, ['except' => ['show']]);

            Route::get('/users/import/eol', [ImportEolController::class, 'show'])->name('users.import_eol');
            Route::post('/users/import/eol', [ImportEolController::class, 'upload'])->name('users.import_eol_upload');

            Route::get('/users/cleanup', [UserCleanupController::class, 'show'])->name('users.cleanup');
            Route::post('/users/cleanup', [UserCleanupController::class, 'clean'])->name('users.cleanup_do');

            Route::get('/users/{user}/delete', [UserController::class, 'delete'])->name('users.delete');
            Route::delete('/users', [UserController::class, 'destroy'])->name('users.destroy');

            Route::resource('users', UserController::class, ['except' => ['show', 'destroy']]);

            Route::get('/links/{short}/delete', [LinkController::class, 'delete'])->name('links.delete');
            Route::delete('/links', [LinkController::class, 'destroy'])->name('links.destroy');

            Route::resource('links', LinkController::class, ['except' => ['show', 'destroy']]);

            Route::get('grouplogin', [GroupLoginController::class, 'index']);
            Route::get('grouplogin/{group}', [GroupLoginController::class, 'show']);
            Route::post('grouplogin/{group}', [GroupLoginController::class, 'do']);
        });
    });

    Route::view('passwords', 'auth.passwords');
    Route::get('login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.submit');
    Route::get('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

    Route::get('password/reset', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
};

if (env('APP_ENV') === 'local' || env('APP_ENV') === 'testing') {
    Route::group([], $loginRoutes);
} else {
    $domains = ['login.curio.codes'];

    foreach ($domains as $domain) {
        Route::group(['domain' => $domain], $loginRoutes);
    }
}

Route::group(['domain' => 'api.curio.codes'], $apiRoutes);
Route::group(['domain' => 'curio.codes'], $mainRoutes);
