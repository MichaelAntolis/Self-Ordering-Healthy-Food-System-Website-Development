<!-- web.php -->
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController as HomeController;
use App\Http\Controllers\MenuController as MenuController;
use App\Http\Controllers\CartController as CartController;
use App\Http\Controllers\CheckoutController as CheckoutController;
use App\Http\Controllers\OrderController as OrderController;
use App\Http\Controllers\AuthController as AuthController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FoodController as AdminFoodController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;

// Main Website Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Profile Routes (Auth Required)
Route::middleware('auth:customer')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::get('/customer/profile', [AuthController::class, 'profile'])->name('customer.profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
});

// Menu Routes
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/menu/{food}', [MenuController::class, 'show'])->name('menu.show');

// Cart Routes
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove.delete');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

// Checkout & Order Routes (Auth Required)
Route::middleware('auth:customer')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}/status', [OrderController::class, 'status'])->name('orders.status');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders', [OrderController::class, 'history'])->name('orders.history');
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth:customer', 'admin'])->group(function () {
    // Dashboard
    Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/change-password', [AdminProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Resources
    Route::resource('foods', AdminFoodController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('customers', AdminCustomerController::class);
    Route::resource('orders', AdminOrderController::class);
    
    // AJAX Routes for Orders
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatusAjax'])->name('orders.update-status-ajax');
    
    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/category-foods', [AdminReportController::class, 'categoryFoods'])->name('category-foods');
        Route::get('/top-customers', [AdminReportController::class, 'topCustomers'])->name('top-customers');
        Route::get('/popular-foods', [AdminReportController::class, 'popularFoods'])->name('popular-foods');
        Route::get('/sales', [AdminReportController::class, 'sales'])->name('sales');
        Route::get('/payment-stats', [AdminReportController::class, 'paymentStats'])->name('payment-stats');
        Route::get('/nutrition-analytics', [AdminReportController::class, 'nutritionAnalytics'])->name('nutrition-analytics');
        Route::get('/customer-preferences', [AdminReportController::class, 'customerPreferences'])->name('customer-preferences');
    });
});