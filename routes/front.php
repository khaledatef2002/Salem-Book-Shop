<?php

use App\Http\Controllers\front\BooksController;
use App\Http\Controllers\front\HomeController;
use App\Http\Controllers\front\QuotesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::name('front.')->group(function(){
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/about', [HomeController::class, 'about'])->name('about');
    Route::get('/contact', [HomeController::class, 'contact'])->middleware('auth')->name('contact');
    Route::post('/contact', [HomeController::class, 'add_contact'])->middleware('auth');

    Route::resource('book', BooksController::class);
    Route::get('/getAllBooksAjax', [BooksController::class, 'getAllBooksAjax']);
    
    Route::middleware('auth')->group(function(){
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
        Route::post('/profile/general_info', [ProfileController::class, 'update'])->name('profile.general');
        Route::post('/profile/update_password', [ProfileController::class, 'update_password'])->name('profile.password');
    });
    
    Route::resource('quote', QuotesController::class);
    Route::get('/getAllQuotesAjax', [QuotesController::class, 'getAllQuotesAjax']);
    Route::post('quotes/like', [QuotesController::class, 'likeAction']);

    Route::get('books/download/{id}', [BooksController::class, 'download'])->name('books.download');
});