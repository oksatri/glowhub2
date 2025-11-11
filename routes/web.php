<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Back\UserController;
use App\Http\Controllers\Front\MuaController as FrontMuaController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Back\ContentController;
use App\Http\Controllers\Back\ProfileController;
use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Back\SiteSettingController;
use App\Http\Controllers\Back\TestimonialController;
use App\Http\Controllers\Back\MuaPortfolioController as BackMuaPortfolioController;
use App\Http\Controllers\Back\MuaController as BackMuaController;
use App\Http\Controllers\Back\MuaServiceController as BackMuaServiceController;

Route::get('/', [HomeController::class, 'index'])->name('home');
// Routes yang bisa diakses oleh semua role
Route::get('/mua-listing', [FrontMuaController::class, 'index'])->name('mua.listing');
Route::get('/mua/{id}', [FrontMuaController::class, 'show'])->name('mua.detail');
Route::post('/mua/{id}/book', [FrontMuaController::class, 'book'])->name('mua.book');


// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/do-login', [AuthController::class, 'doLogin'])->name('auth.login');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/do-register', [AuthController::class, 'doRegister'])->name('auth.register');
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('/do-forgot', [AuthController::class, 'doForgot'])->name('auth.forgot-password');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Profile routes for authenticated users
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');


    // Admin routes
    Route::middleware([RoleMiddleware::class . ':admin'])->group(function () {
        // Tambahkan route khusus admin di sini
        // Contoh: Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        // Register resource routes for content management with admin. name prefix
        Route::resource('content-management', ContentController::class, ['as' => 'admin']);
        // Additional actions: publish / unpublish
        Route::post('content-management/{id}/publish', [ContentController::class, 'publish'])->name('content.publish');
        Route::post('content-management/{id}/unpublish', [ContentController::class, 'unpublish'])->name('content.unpublish');
        // Testimonials resource
        Route::resource('testimonials', TestimonialController::class, ['as' => 'admin']);
        // Site settings (single page)
        Route::get('settings', [SiteSettingController::class, 'index'])->name('admin.settings.index');
        Route::post('settings', [SiteSettingController::class, 'update'])->name('admin.settings.update');
        // Users management
        Route::resource('users', UserController::class, ['as' => 'admin']);

        // MUA management
        Route::resource('muas', BackMuaController::class, ['as' => 'admin']);
        // Nested MUA services (muas/{mua}/services)
        Route::post('muas/{mua}/services', [BackMuaServiceController::class, 'store'])->name('admin.muas.services.store');
        Route::delete('muas/{mua}/services/{id}', [BackMuaServiceController::class, 'destroy'])->name('admin.muas.services.destroy');
        // Portfolios
        Route::post('muas/{mua}/portfolios', [BackMuaPortfolioController::class, 'store'])->name('admin.muas.portfolios.store');
        Route::delete('muas/{mua}/portfolios/{id}', [BackMuaPortfolioController::class, 'destroy'])->name('admin.muas.portfolios.destroy');
        // Bookings
        Route::get('bookings', [\App\Http\Controllers\Back\BookingController::class, 'index'])->name('admin.bookings.index');
        Route::get('bookings/pending', [\App\Http\Controllers\Back\BookingController::class, 'pending'])->name('admin.bookings.pending');
        Route::put('bookings/{id}', [\App\Http\Controllers\Back\BookingController::class, 'update'])->name('admin.bookings.update');
    });

    // MUA routes
    Route::middleware([\App\Http\Middleware\RoleMiddleware::class . ':mua'])->group(function () {
        // Tambahkan route khusus mua di sini
        // Contoh: Route::get('/mua/dashboard', [MuaController::class, 'dashboard'])->name('mua.dashboard');
        // Bookings (MUA-specific route names, under /mua prefix to avoid URI collision)
        Route::get('mua/bookings', [\App\Http\Controllers\Back\BookingController::class, 'index'])->name('mua.bookings.index');
        Route::get('mua/bookings/pending', [\App\Http\Controllers\Back\BookingController::class, 'pending'])->name('mua.bookings.pending');
        Route::put('mua/bookings/{id}', [\App\Http\Controllers\Back\BookingController::class, 'update'])->name('mua.bookings.update');

        // MUA management
        Route::resource('muas', BackMuaController::class, [
            'as' => 'admin'
        ])->only(['create', 'store', 'edit', 'update']);
        // Nested MUA services (muas/{mua}/services)
        Route::post('muas/{mua}/services', [BackMuaServiceController::class, 'store'])->name('muas.services.store');
        Route::delete('muas/{mua}/services/{id}', [BackMuaServiceController::class, 'destroy'])->name('muas.services.destroy');
        // Portfolios
        Route::post('muas/{mua}/portfolios', [BackMuaPortfolioController::class, 'store'])->name('muas.portfolios.store');
        Route::delete('muas/{mua}/portfolios/{id}', [BackMuaPortfolioController::class, 'destroy'])->name('muas.portfolios.destroy');
    });
    // Member routes
    Route::middleware('role:member')->group(function () {
        // Tambahkan route khusus member di sini
        // Contoh: Route::get('/member/profile', [MemberController::class, 'profile'])->name('member.profile');
    });
});
