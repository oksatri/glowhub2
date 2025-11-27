<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Back\UserController;
use App\Http\Controllers\Front\MuaController as FrontMuaController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Back\BookingController;
use App\Http\Controllers\Mua\BookingConfirmationController;
use App\Http\Controllers\Back\ProfileController;
use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Back\SiteSettingController;
use App\Http\Controllers\Back\TestimonialController;
use App\Http\Controllers\Back\MuaPortfolioController as BackMuaPortfolioController;
use App\Http\Controllers\Back\MuaController as BackMuaController;
use App\Http\Controllers\Back\MuaServiceController as BackMuaServiceController;
use App\Http\Controllers\Back\PaymentMethodController;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

Route::get('/check-public', function () {
    return public_path();
});

Route::get('/glowhub-cmd', function (Request $request) {
    $secret = 'glowhub1607'; // ganti dengan token rahasia kamu sendiri

    if ($request->get('key') !== $secret) {
        abort(403, 'Unauthorized');
    }

    $command = $request->get('cmd'); // ambil command dari query string

    if ($command === 'pull') {
        // 1. Tentukan path ke direktori root repositori Git Anda.
        // Ini harus berupa path absolut di server Anda.
        $repo_path = '/home/glowhubi/glowhub_back'; // Ganti dengan path yang sesuai

        // 2. Tentukan perintah shell yang akan dijalankan.
        // '2>&1' memastikan output dan error ditangkap.
        $full_command = "cd $repo_path && /usr/bin/git pull origin main 2>&1";

        try {
            // Jalankan perintah sistem
            $output = shell_exec($full_command);

            return "<pre>Perintah 'git pull' berhasil dijalankan ✅\n\nOutput:\n{$output}</pre>";

        } catch (\Exception $e) {
            return "<pre>Error: {$e->getMessage()}</pre>";
        }

    } else {
        // Jika perintah bukan 'pull', jalankan sebagai Artisan (sesuai kode asli Anda)
        try {
            \Illuminate\Support\Facades\Artisan::call($command);
            return "<pre>Command '{$command}' berhasil dijalankan ✅\n\n" . \Illuminate\Support\Facades\Artisan::output() . "</pre>";
        } catch (\Exception $e) {
            return "<pre>Error: {$e->getMessage()}</pre>";
        }
    }
});
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

// Client booking actions (can be accessed by anyone with booking ID)
Route::get('/booking/price/accept/{id}', [\App\Http\Controllers\Front\BookingController::class, 'acceptPriceRevision'])->name('booking.price.accept');
Route::get('/booking/price/reject/{id}', [\App\Http\Controllers\Front\BookingController::class, 'rejectPriceRevision'])->name('booking.price.reject');
Route::get('/booking/invoice/{id}', [\App\Http\Controllers\Front\BookingController::class, 'showInvoice'])->name('front.booking.invoice');

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
        Route::resource('content-management', \App\Http\Controllers\Back\ContentController::class, ['as' => 'admin']);
        // Additional actions: publish / unpublish
        Route::post('content-management/{id}/publish', [\App\Http\Controllers\Back\ContentController::class, 'publish'])->name('content.publish');
        Route::post('content-management/{id}/unpublish', [\App\Http\Controllers\Back\ContentController::class, 'unpublish'])->name('content.unpublish');
        // Testimonials resource
        Route::resource('testimonials', TestimonialController::class, ['as' => 'admin']);
        // Site settings (single page)
        Route::get('settings', [SiteSettingController::class, 'index'])->name('admin.settings.index');
        Route::post('settings', [SiteSettingController::class, 'update'])->name('admin.settings.update');
        // Users management
        Route::resource('users', UserController::class, ['as' => 'admin']);

        // Payment Methods management
        Route::resource('payment-methods', PaymentMethodController::class, ['as' => 'admin']);
        Route::post('payment-methods/reorder', [PaymentMethodController::class, 'reorder'])->name('admin.payment-methods.reorder');
        Route::post('payment-methods/{paymentMethod}/toggle', [PaymentMethodController::class, 'toggleStatus'])->name('admin.payment-methods.toggle');

        // MUA management (admin area)
        // Provide GET /muas that redirects to /admin/muas for admins so the
        // GET method is available (previously only POST /muas existed because
        // muas resource for MUA users registers only create/store/edit/update).
        Route::get('muas', function () {
            return redirect('admin/muas');
        });
        Route::resource('admin/muas', BackMuaController::class, ['as' => 'admin']);
        // Nested MUA services (admin/muas/{mua}/services)
        Route::post('admin/muas/{mua}/services', [BackMuaServiceController::class, 'store'])->name('admin.muas.services.store');
        Route::put('admin/muas/{mua}/services/{id}', [BackMuaServiceController::class, 'update'])->name('admin.muas.services.update');
        Route::delete('admin/muas/{mua}/services/{id}', [BackMuaServiceController::class, 'destroy'])->name('admin.muas.services.destroy');
        // Portfolios
        Route::post('admin/muas/{mua}/portfolios', [BackMuaPortfolioController::class, 'store'])->name('admin.muas.portfolios.store');
        Route::put('admin/muas/{mua}/portfolios/{id}', [BackMuaPortfolioController::class, 'update'])->name('admin.muas.portfolios.update');
        Route::delete('admin/muas/{mua}/portfolios/{id}', [BackMuaPortfolioController::class, 'destroy'])->name('admin.muas.portfolios.destroy');
        // Bookings (admin area) — use an explicit admin URI to avoid collision with MUA routes
        Route::get('admin/bookings', [\App\Http\Controllers\Back\BookingController::class, 'index'])->name('admin.bookings.index');
        Route::get('admin/bookings/pending', [\App\Http\Controllers\Back\BookingController::class, 'pending'])->name('admin.bookings.pending');
        Route::put('admin/bookings/{id}', [\App\Http\Controllers\Back\BookingController::class, 'update'])->name('admin.bookings.update');
    });

    // MUA routes
    Route::middleware('auth')->group(function () { // Temporarily remove role middleware
        // Tambahkan route khusus mua di sini
        // Contoh: Route::get('/mua/dashboard', [MuaController::class, 'dashboard'])->name('mua.dashboard');
        // Bookings (MUA-specific route names, under /mua prefix to avoid URI collision)
        Route::get('auth-mua/bookings', [\App\Http\Controllers\Back\BookingController::class, 'index'])->name('auth-mua.bookings.index');
        Route::get('auth-mua/bookings/pending', [\App\Http\Controllers\Back\BookingController::class, 'pending'])->name('auth-mua.bookings.pending');
        Route::put('auth-mua/bookings/{id}', [\App\Http\Controllers\Back\BookingController::class, 'update'])->name('auth-mua.bookings.update');

        // MUA Booking Confirmation Routes
        Route::get('mua/bookings/confirm/{id}', [BookingConfirmationController::class, 'show'])->name('mua.bookings.confirm.show');
        Route::post('mua/bookings/confirm/{id}', [BookingConfirmationController::class, 'confirm'])->name('mua.bookings.confirm');
        Route::post('mua/bookings/reject/{id}', [BookingConfirmationController::class, 'reject'])->name('mua.bookings.reject');
        Route::post('mua/bookings/revise-price/{id}', [BookingConfirmationController::class, 'revisePrice'])->name('mua.bookings.revise-price');

        // MUA management
        Route::resource('muas', BackMuaController::class, [
            'as' => 'admin'
        ])->only(['create', 'store', 'edit', 'update']);
        // Nested MUA services (muas/{mua}/services)
        Route::post('muas/{mua}/services', [BackMuaServiceController::class, 'store'])->name('muas.services.store');
        Route::put('muas/{mua}/services/{id}', [BackMuaServiceController::class, 'update'])->name('muas.services.update');
        Route::delete('muas/{mua}/services/{id}', [BackMuaServiceController::class, 'destroy'])->name('muas.services.destroy');
        // Portfolios
        Route::post('muas/{mua}/portfolios', [BackMuaPortfolioController::class, 'store'])->name('muas.portfolios.store');
        Route::put('muas/{mua}/portfolios/{id}', [BackMuaPortfolioController::class, 'update'])->name('muas.portfolios.update');
        Route::delete('muas/{mua}/portfolios/{id}', [BackMuaPortfolioController::class, 'destroy'])->name('muas.portfolios.destroy');
    });
    // Member routes
    Route::middleware([RoleMiddleware::class . ':member'])->group(function () {
        // Tambahkan route khusus member di sini
        // Contoh: Route::get('/member/profile', [MemberController::class, 'profile'])->name('member.profile');
    });
});
