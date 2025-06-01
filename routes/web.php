<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReviewController;

// Public landing page
Route::get('/', fn() => view('welcome'));

// User authentication + verified middleware
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // User dashboard
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // Product browsing
    Route::get('/products/category/{categoryName}', [ProductController::class, 'showByCategory'])
        ->name('products.byCategory');
    Route::get('/products/{product}', [ProductController::class, 'showView'])
        ->name('product.show');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Review submission (user-side), nested by product
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])
        ->name('products.reviews.store');
});

// Success page after checkout
Route::get('/order-success', fn() => view('checkout.success'))->name('orders.success');

// Admin authentication routes
Route::get('admin/login', [AdminController::class, 'loginForm']);
Route::post('admin/login', [AdminController::class, 'store'])->name('admin.login');
Route::post('admin/logout', function () {
    Auth::guard('admin')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/admin/login');
})->name('admin.logout');

// Admin dashboard & management routes
Route::middleware(['auth:admin', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
        
        // User Management
        Route::get('/users', fn() => view('admin.users'))->name('users');

        // Product Management
        Route::get('/products', [ProductController::class, 'adminProductsPage'])->name('products');

        // Order Management
        Route::resource('orders', OrderController::class);

        // Review Management (admin view & delete)
        Route::get('/reviews', [ReviewController::class, 'adminIndex'])->name('reviews.index');
        Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// Contact page
Route::get('/contact', fn() => view('contact'))->name('contact');
