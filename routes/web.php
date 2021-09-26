<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\RoleController;
use App\Http\Controllers\Web\UserController;
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
    return view('authentication.login');
});

Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index']);

        Route::get('users', [UserController::class, 'index'])->middleware('permission:user.show');

        Route::prefix('roles')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->middleware('permission:role.show');
            Route::get('create', [RoleController::class, 'create'])->middleware('permission:role.create');
            Route::get('/{id}/edit', [RoleController::class, 'edit'])->middleware('permission:role.edit');
        });
    });
});
