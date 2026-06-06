<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// TEMPORARY — delete this route after promoting your admin user
Route::get('/promote-super-admin', function () {
  

    $user = \App\Models\User::where('email','vicken408@gmail.com')->firstOrFail();
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'super-admin']);
    $user->syncRoles(['super-admin']);

    return 'Done. ' . $user->email . ' is now super-admin. Delete /promote-super-admin from routes/web.php now.';
});

Route::get('/', [App\Http\Controllers\PageController::class, 'home'])->name('landing');

// About Page
Route::get('/about', [App\Http\Controllers\PageController::class, 'about'])->name('about');

// Blog Routes
Route::get('/blog', [App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/archive', [App\Http\Controllers\BlogController::class, 'archive'])->name('blog.archive');
Route::get('/blog/{blog:slug}', [App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');

// Contact Page
Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

Route::post('payment/webhook', [App\Http\Controllers\PaymentController::class, 'handleWebhook'])
    ->name('payment.webhook');

Route::get('sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');

// Free content downloads
Route::get('download/{product:slug}', [App\Http\Controllers\DigitalContentController::class, 'download'])
    ->name('download.product');

Route::get('content/{product:slug}/deliver', [App\Http\Controllers\DigitalContentController::class, 'deliver'])
    ->middleware('signed')
    ->name('content.deliver');
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/products/search', [App\Http\Controllers\ProductController::class, 'search'])->name('products.search');
Route::get('/products/{product:slug}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');

// SEO Category Landing Pages
Route::get('/christian-audiobooks', [App\Http\Controllers\SeoCategoryController::class, 'christianAudiobooks'])->name('seo.christian-audiobooks');
Route::get('/children-audiobooks', [App\Http\Controllers\SeoCategoryController::class, 'childrenStories'])->name('seo.children-stories');
Route::get('/commuter-audiobooks', [App\Http\Controllers\SeoCategoryController::class, 'commuterAudiobooks'])->name('seo.commuter-audiobooks');
Route::get('/inspiration-health', [App\Http\Controllers\SeoCategoryController::class, 'inspirationHealth'])->name('seo.inspiration-health');





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
    Route::get('/email/verify', [App\Http\Controllers\EmailVerificationController::class, 'notice'])
        ->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [App\Http\Controllers\EmailVerificationController::class, 'verify'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('/email/verification-notification', [App\Http\Controllers\EmailVerificationController::class, 'send'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::post('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/home', function () {
        $user = auth()->user();
        if ($user->hasRole('admin') || $user->hasRole('super-admin')) {
            return redirect()->route('admin.dashboard');
        }
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return redirect()->route('user.dashboard');
    })->name('home');

    Route::view('profile', 'profile')->name('profile');
    Route::post('profile/name', [ProfileController::class, 'changeName'])->name('changeName');
    Route::post('profile/password', [ProfileController::class, 'changePassword'])->name('changePassword');

    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
    // Route::middleware(['role:admin|super-admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::delete('products/bulk-delete', [App\Http\Controllers\Admin\ProductController::class, 'bulkDelete'])->name('products.bulk-delete');
        Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
        Route::post('products/{product}/toggle-status', [App\Http\Controllers\Admin\ProductController::class, 'toggleStatus'])->name('products.toggle-status');
        Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::post('categories/{category}/toggle-status', [App\Http\Controllers\Admin\CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
        Route::resource('orders', App\Http\Controllers\Admin\OrderController::class);
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::resource('blogs', App\Http\Controllers\Admin\BlogController::class);
        Route::post('blogs/{blog}/toggle-status', [App\Http\Controllers\Admin\BlogController::class, 'toggleStatus'])->name('blogs.toggle-status');
        Route::resource('pages', App\Http\Controllers\Admin\PageController::class)->except(['show']);
        
        // Admin User Management (Super Admin Only)
        Route::resource('admin-users', App\Http\Controllers\Admin\AdminUserController::class)->except(['edit', 'update']);
        
        // Media upload (GrapesJS asset manager)
        Route::post('/media/upload', [App\Http\Controllers\Admin\MediaUploadController::class, 'upload'])->name('media.upload');

        // Site Settings
        Route::get('/settings', [App\Http\Controllers\Admin\SiteSettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [App\Http\Controllers\Admin\SiteSettingController::class, 'update'])->name('settings.update');

        // System activity audit
        Route::get('/activity', [App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity.index');
        Route::get('/activity/export', [App\Http\Controllers\Admin\ActivityLogController::class, 'export'])->name('activity.export');

        Route::get('/reports', [App\Http\Controllers\Admin\ReportsController::class, 'index'])->name('reports.index');
        Route::get('/exports/orders', [App\Http\Controllers\Admin\ExportController::class, 'orders'])->name('exports.orders');
        Route::get('/exports/customers', [App\Http\Controllers\Admin\ExportController::class, 'customers'])->name('exports.customers');
        Route::get('/orders/{order}/receipt', [App\Http\Controllers\OrderReceiptController::class, 'download'])->name('orders.receipt');
    });

        // Payment routes (verified email required for checkout)
           Route::prefix('payment')->name('payment.')->middleware('verified')->group(function () {
               Route::post('checkout', [App\Http\Controllers\PaymentController::class, 'checkout'])->name('checkout');
               Route::get('success', [App\Http\Controllers\PaymentController::class, 'handleCheckoutSuccess'])->name('success');
               Route::post('intent/{order}', [App\Http\Controllers\PaymentController::class, 'createPaymentIntent'])->name('intent');
               Route::post('refund/{order}', [App\Http\Controllers\PaymentController::class, 'refund'])
                   ->middleware(['role:admin|super-admin'])
                   ->name('refund');
           });

    // User routes (verified email required for library & paid downloads)
    Route::middleware(['verified'])->prefix('user')->name('user.')->group(function () {
        Route::get('dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
        Route::get('orders', [App\Http\Controllers\User\DashboardController::class, 'orders'])->name('orders');
        Route::get('download/{product:slug}', [App\Http\Controllers\DigitalContentController::class, 'download'])->name('download');
        Route::get('stream/{product:slug}', [App\Http\Controllers\DigitalContentController::class, 'stream'])->name('stream');
        Route::get('orders/{order}/receipt', [App\Http\Controllers\OrderReceiptController::class, 'download'])->name('orders.receipt');
    });

});

Route::get('/{slug}', [App\Http\Controllers\PageController::class, 'show'])
    ->where('slug', '[a-zA-Z0-9\-]+')
    ->name('pages.show');
