<?php

use App\Http\Controllers\Api\ApiPositionController;
use App\Http\Controllers\Api\ApiRoleController;
use App\Http\Controllers\Api\ApiUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('admin')->group(function () {

        Route::prefix('roles')->group(function () {
            Route::get('/', [ApiRoleController::class, 'index'])->middleware('permission:role.read');
            Route::post('/', [ApiRoleController::class, 'store'])->middleware('permission:role.create');
            Route::put('{id}/update', [ApiRoleController::class, 'update'])->middleware('permission:role.update');
            Route::delete('{id}/delete', [ApiRoleController::class, 'destroy'])->middleware('permission:role.delete');
        });

        Route::prefix('users')->group(function () {
            Route::get('/', [ApiUserController::class, 'index'])->middleware('permission:user.read');
            Route::post('/', [ApiUserController::class, 'store'])->middleware('permission:user.create');
            Route::put('{id}/update', [ApiUserController::class, 'update'])->middleware('permission:user.update');
            Route::delete('{id}/delete', [ApiUserController::class, 'destroy'])->middleware('permission:user.delete');
        });
    });
});
