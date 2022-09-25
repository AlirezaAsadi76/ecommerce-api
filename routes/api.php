<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers;

Route::post('register',[Controllers\Auth\RegisterUserController::class,'register'])->name('register');

Route::post('login',[Controllers\Auth\LoginUserController::class,'login'])->name('login')->middleware(['throttle:login']);
Route::post('logout',[Controllers\Auth\LogoutController::class,'login'])->name('logout')->middleware('auth');

Route::name('shop.')->controller(Controllers\ShopController::class)->group(function () {
    Route::get('shop','index')->name('index');
    Route::get('shop/{slug}','show')->name('show');
    Route::get('shop/search/{query}','query')->name('search');

});

Route::middleware(['auth','admin'])->prefix('admin')->group(function () {
    Route::resource('products',Controllers\Admin\ProductController::class)->except('show');
    Route::resource('tags',Controllers\Admin\TagController::class)->only(['index','store','update','destroy']);
    Route::resource('categories',Controllers\Admin\CategoryController::class)->only(['index','store','update','destroy']);
    Route::resource('orders',Controllers\Admin\OrderController::class)->only(['index','show']);
});

Route::middleware('auth')
    ->name('carts.')
    ->controller(Controllers\CartController::class)
    ->group( function () {
        Route::get('carts','index')->name('index');
    });
