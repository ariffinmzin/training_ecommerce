<?php

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
    return view('welcome');
});

Auth::routes();

Route::group([
    'prefix' => '',
    'middleware' => ['auth'],
], function(){

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'getProfile'])->name('profile');
    Route::post('/profile', [App\Http\Controllers\ProfileController::class, 'postProfile'])->name('profile.post');
    Route::get('/order/{product}', [App\Http\Controllers\OrderController::class, 'getOrder'])->name('order');
    Route::post('/order', [App\Http\Controllers\OrderController::class, 'postOrder'])->name('order.post');
    Route::get('/myorder', [App\Http\Controllers\OrderController::class, 'myorder'])->name('myorder');

    //demo api
    Route::get('/api/v1/customer', [App\Http\Controllers\ApiController::class, 'customer'])->name('api.customer');

    Route::group([
        'prefix' => 'admin',
        'middleware' => ['admin'],
    ], function(){

        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'dashboard'])->name('admin.dashboard');
        Route::resource('product', 'App\Http\Controllers\Admin\ProductController');
        Route::get('/search', [App\Http\Controllers\Admin\OrderController::class, 'search'])->name('order.search');
        Route::get('/order/pdf', [App\Http\Controllers\Admin\OrderController::class, 'pdf'])->name('order.pdf');
        Route::get('/order/excel', [App\Http\Controllers\Admin\OrderController::class, 'excel'])->name('order.excel');
        Route::resource('order', 'App\Http\Controllers\Admin\OrderController');

    });

});






