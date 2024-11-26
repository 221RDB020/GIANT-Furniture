<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Checkout\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Wishlist\WishlistController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;

Route::get('/', HomeController::class)->name('home');
Route::get('/categories/{category}', [ShopController::class, 'index'])->name('shop.index');
Route::get('/categories/{category}/{product}', [ShopController::class, 'show'])->name('shop.show');

Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.add');
Route::put('/cart', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.remove');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.add');
Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.remove');

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
});

Route::group(['namespace' => 'MyGiant', 'prefix' => 'mygiant', 'middleware' => 'auth'], function () {
    Route::group(['namespace' => 'Profile', 'prefix' => 'profile'], function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
        Route::put('/', [ProfileController::class, 'update'])->name('profile.update');

        Route::post('/address', [ProfileController::class, 'addAddress'])->name('profile.addAddress');
    });
});

Auth::routes();

