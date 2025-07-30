<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index']);

// Digital Content Download Route
Route::get('download/{product}', [App\Http\Controllers\DigitalContentController::class, 'download'])->name('download.product');
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');



Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::view('register', 'auth.register')->name('register');
    Route::view('register/success', 'auth.success')->name('register.success');


    Route::controller(AuthController::class)->prefix('auth')->name('auth.')->group(function () {
        Route::post('/register', 'register')->name('register');
        Route::post('/login', 'login')->name('login');
    });
    Route::controller(PasswordResetController::class)->group(function () {
        Route::get('forgot-password', 'index')->name('password.request');
        Route::post('forgot-password', 'store')->name('password.email');
        Route::get('/reset-password/{token}', 'reset')->name('password.reset');
        Route::post('/reset-password', 'update')->name('password.update');
    });
});


Route::middleware(['auth'])->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/home', function () {
        $user = auth()->user();
        if ($user->hasRole('admin') || $user->hasRole('super-admin')) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    })->name('home');

    Route::view('profile', 'profile')->name('profile');
    Route::post('profile/name', [ProfileController::class, 'changeName'])->name('changeName');
    Route::post('profile/password', [ProfileController::class, 'changePassword'])->name('changePassword');

    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
    // Route::middleware(['role:admin|super-admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
        Route::post('products/{product}/toggle-status', [App\Http\Controllers\Admin\ProductController::class, 'toggleStatus'])->name('products.toggle-status');
        Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::post('categories/{category}/toggle-status', [App\Http\Controllers\Admin\CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
        Route::resource('orders', App\Http\Controllers\Admin\OrderController::class);
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    });

        // Payment routes
           Route::prefix('payment')->name('payment.')->group(function () {
               Route::post('checkout', [App\Http\Controllers\PaymentController::class, 'checkout'])->name('checkout');
               Route::get('success', [App\Http\Controllers\PaymentController::class, 'handleCheckoutSuccess'])->name('success');
               Route::post('intent/{order}', [App\Http\Controllers\PaymentController::class, 'createPaymentIntent'])->name('intent');
               Route::post('webhook', [App\Http\Controllers\PaymentController::class, 'handleWebhook'])->name('webhook');
               Route::post('refund/{order}', [App\Http\Controllers\PaymentController::class, 'refund'])
                   ->middleware(['role:admin|super-admin'])
                   ->name('refund');
           });

    // User routes
    Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
        Route::get('dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
        Route::get('orders', [App\Http\Controllers\User\DashboardController::class, 'orders'])->name('orders');
        Route::get('download/{product}', [App\Http\Controllers\User\DashboardController::class, 'download'])->name('download');
        Route::get('stream/{product}', [App\Http\Controllers\User\DashboardController::class, 'stream'])->name('stream');
    });

});
