<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\RoleController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\WebAdminDashboardController;
use App\Http\Controllers\Web\WebAdminRoleController;
use App\Http\Controllers\Web\WebAdminUserController;
use App\Http\Controllers\Web\WebAuthController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
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

require base_path('routes/asset.php');

Route::get('/', function () {
    return view('authentication.login');
})->name('login');

Route::post('auth/login', [WebAuthController::class, 'loginProsses']);

Route::middleware('auth')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('dashboard', [WebAdminDashboardController::class, 'index']);

        Route::get('users', [WebAdminUserController::class, 'index'])->middleware('permission:user.read');

        Route::prefix('roles')->group(function () {
            Route::get('/', [WebAdminRoleController::class, 'index'])->middleware('permission:role.read');
            Route::get('create', [WebAdminRoleController::class, 'create'])->middleware('permission:role.create');
            Route::get('/{id}/edit', [WebAdminRoleController::class, 'edit'])->middleware('permission:role.update');
        });
    });
});
