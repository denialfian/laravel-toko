<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\RoleController;
use App\Http\Controllers\Web\UserController;
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

Route::middleware('asset_cache')->group(function () {
    Route::get('plugins-bundle-js', function () {
        $path = public_path('backend/assets/plugins/global/plugins.bundlef552.js');
        if (!File::exists($path)) {
            abort(404);
        }

        $response = Response::make(File::get($path), 200);
        $response->header("Content-Type", 'text/javascript');
        return $response;
    });

    Route::get('prismjs-bundle-js', function () {
        $path = public_path('backend/assets/plugins/custom/prismjs/prismjs.bundlef552.js');
        if (!File::exists($path)) {
            abort(404);
        }

        $response = Response::make(File::get($path), 200);
        $response->header("Content-Type", 'text/javascript');
        return $response;
    });

    Route::get('scripts-bundle-js', function () {
        $path = public_path('backend/assets/js/scripts.bundlef552.js');
        if (!File::exists($path)) {
            abort(404);
        }

        $response = Response::make(File::get($path), 200);
        $response->header("Content-Type", 'text/javascript');
        return $response;
    });

    Route::get('plugins-bundle-css', function () {
        $path = public_path('backend/assets/plugins/global/plugins.bundlef552.css');
        if (!File::exists($path)) {
            abort(404);
        }

        $response = Response::make(File::get($path), 200);
        $response->header("Content-Type", 'text/css');
        return $response;
    });

    Route::get('prismjs-bundle-css', function () {
        $path = public_path('backend/assets/plugins/custom/prismjs/prismjs.bundlef552.css');
        if (!File::exists($path)) {
            abort(404);
        }

        $response = Response::make(File::get($path), 200);
        $response->header("Content-Type", 'text/css');
        return $response;
    });

    Route::get('style-bundle-css', function () {
        $path = public_path('backend/assets/css/style.bundlef552.css');
        if (!File::exists($path)) {
            abort(404);
        }

        $response = Response::make(File::get($path), 200);
        $response->header("Content-Type", 'text/css');
        return $response;
    });

    Route::get('themes-layout-header-menu-light-css', function () {
        $path = public_path('backend/assets/css/themes/layout/header/menu/lightf552.css');
        if (!File::exists($path)) {
            abort(404);
        }

        $response = Response::make(File::get($path), 200);
        $response->header("Content-Type", 'text/css');
        return $response;
    });
    
    Route::get('themes-layout-aside-dark-css', function () {
        $path = public_path('backend/assets/css/themes/layout/aside/darkf552.css');
        if (!File::exists($path)) {
            abort(404);
        }

        $response = Response::make(File::get($path), 200);
        $response->header("Content-Type", 'text/css');
        return $response;
    });
});
