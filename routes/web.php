<?php

use Illuminate\Support\Facades\Route;
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

Route::get('/mua-listing', [MuaController::class, 'index'])->name('mua.listing');
Route::get('/mua/{id}', [MuaController::class, 'show'])->name('mua.detail');
Route::post('/mua/{id}/book', [MuaController::class, 'book'])->name('mua.book');
