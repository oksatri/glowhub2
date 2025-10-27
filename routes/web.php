<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MuaController;

Route::get('/', function () {
    return view('home');
});

Route::get('/mua-listing', [MuaController::class, 'index'])->name('mua.listing');
Route::get('/mua/{id}', [MuaController::class, 'show'])->name('mua.detail');
Route::post('/mua/{id}/book', [MuaController::class, 'book'])->name('mua.book');
