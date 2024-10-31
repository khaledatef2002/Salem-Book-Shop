<?php

use App\Http\Controllers\dashboard\HomeController;
use Illuminate\Support\Facades\Route;

Route::name('dashboard.')->middleware('auth', 'admin')->prefix('dashboard')->group(function(){
    Route::get('/', [HomeController::class, 'index'])->name('index');
});