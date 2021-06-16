<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return view('welcome');
});

Auth::routes();
Route::get('/dashbord', [App\Http\Controllers\HomeController::class, 'index'])->name('dashbord');

route::prefix('admin')->group(function () {
    #admin login
    Route::get('/login', [App\Http\Controllers\Admin\LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [App\Http\Controllers\Admin\LoginController::class, 'login'])->name('admin.login');

    #authenticate Admin
    route::middleware('auth:admin')->group(function(){
        #admin logout
        Route::post('/logout', [App\Http\Controllers\Admin\LoginController::class, 'logout'])->name('admin.logout');

        #dashbord
        Route::get('/dashbord', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashbord');
    });
});


#clear all cache
Route::get('clear-cache',function(){
    Artisan::call('cache:clear');

    Artisan::call('config:cache');
    Artisan::call('config:clear');

    // Artisan::call('route:cache');
    Artisan::call('route:clear');

    Artisan::call('view:cache');
    Artisan::call('view:clear');

    echo 'all cache cleared';
});
