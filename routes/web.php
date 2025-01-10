<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\FollowingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

// ROUTE FOR LOCALIZATION
Route::get('/change-language/{lang}', function ($lang) {
    if (in_array($lang, ['en', 'id'])) {
        Session::put('locale', $lang);
        App::setLocale($lang);
    }
    return redirect()->back();
})->name('changeLanguage');

// ROUTE FOR HOME PAGE

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/filter-users', [HomeController::class, 'filterUsers'])->name('filter-users');

// ROUTE FOR LOGIN / REGISTER
Auth::routes();

// ROUTE FOR PAYMENT
Route::middleware('guest')->prefix('payments')->as('payments.')->group(function() {
    // Payment Index Page
    Route::get('/', [PaymentController::class, 'index'])->name('payment');

    // Submit Payment
    Route::post('/submit', [PaymentController::class, 'submit'])->name('submit');

    // Confirm Overpayment
    Route::post('/confirmOverpayment', [PaymentController::class, 'confirmOverpayment'])->name('confirmOverpayment');
});

// ROUTE FOR USERS
Route::middleware('auth')->prefix('users')->as('users.')->group(function() {
    Route::get('/friend-requests', [UserController::class, 'showFriendRequest'])->name('friend-req');

    Route::resource('/', UserController::class)->parameters(['' => 'user']);
});

// ROUTE FOR WISHLISTS

Route::middleware('auth')->prefix('wishlists')->as('wishlists.')->group(function() {
    Route::resource('/', WishlistController::class)->parameters(['' => 'wishlist']);
});

// ROUTE FOR FOLLOWINGS

Route::middleware('auth')->prefix('followings')->as('followings.')->group(function() {
    Route::resource('/', FollowingController::class)->parameters(['' => 'following']);
});

// ROUTE FOR CHATS

Route::middleware('auth')->prefix('chats')->as('chats.')->group(function() {
    Route::resource('/', ChatController::class)->parameters(['' => 'chat']);
});

// ROUTE FOR NOTIFICATIONS

Route::middleware('auth')->prefix('notifications')->as('notifications.')->group(function() {
    Route::resource('/', NotificationController::class)->parameters(['' => 'notification']);
});
