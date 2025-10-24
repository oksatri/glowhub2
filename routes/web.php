<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MuaController;

Route::get('/', function () {
    return view('home');
});

Route::get('/mua-listing', [MuaController::class, 'index'])->name('mua.listing');
