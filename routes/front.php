<?php

use App\Http\Controllers\front\HomeController;
use Illuminate\Support\Facades\Route;

Route::name('front.')->group(function(){
    Route::get('/', [HomeController::class, 'index'])->name('index');
});