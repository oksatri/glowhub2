<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Front\MuaController;
use App\Http\Controllers\Back\ContentController;
use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Back\ProfileController;
use App\Http\Controllers\Back\TestimonialController;
use App\Http\Controllers\Front\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
// Routes yang bisa diakses oleh semua role
Route::get('/mua-listing', [MuaController::class, 'index'])->name('mua.listing');
Route::get('/mua/{id}', [MuaController::class, 'show'])->name('mua.detail');
Route::post('/mua/{id}/book', [MuaController::class, 'book'])->name('mua.book');


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
    });

    // MUA routes
    Route::middleware('role:mua')->group(function () {
        // Tambahkan route khusus mua di sini
        // Contoh: Route::get('/mua/dashboard', [MuaController::class, 'dashboard'])->name('mua.dashboard');
    });
    // Member routes
    Route::middleware('role:member')->group(function () {
        // Tambahkan route khusus member di sini
        // Contoh: Route::get('/member/profile', [MemberController::class, 'profile'])->name('member.profile');
    });
});
