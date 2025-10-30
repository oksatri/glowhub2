<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Front\MuaController;
use App\Http\Controllers\Back\DashboardController;

Route::get('/', function () {
    return view('front.home');
});
// Routes yang bisa diakses oleh semua role
=======
use App\Http\Controllers\MuaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\HeroSectionController;
use App\Http\Controllers\Admin\HowItWorkController;

Route::get('/', [HomeController::class, 'index'])->name('home');

>>>>>>> 2ab977c434b3a80506b8afe339a615f704bef156
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
    Route::get('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
    // Admin routes
    Route::middleware('role:admin')->group(function () {
        // Tambahkan route khusus admin di sini
        // Contoh: Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
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
