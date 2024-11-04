<?php

use App\helper\select2;
use App\Http\Controllers\dashboard\ArticlesCategories;
use App\Http\Controllers\dashboard\BookController;
use App\Http\Controllers\dashboard\BooksCategoriesController;
use App\Http\Controllers\dashboard\BooksReviewsController;
use App\Http\Controllers\dashboard\HomeController;
use App\Http\Controllers\dashboard\PeopleController;
use App\Http\Controllers\dashboard\QuotesController;
use App\Http\Controllers\dashboard\WebsiteSettingsController;
use Illuminate\Support\Facades\Route;

Route::name('dashboard.')->middleware('auth', 'admin')->prefix('dashboard')->group(function(){
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::resource('website_setting', WebsiteSettingsController::class);

    Route::post('/settings/change-logo', [WebsiteSettingsController::class, 'change_logo']);
    Route::post('/settings/change-banner', [WebsiteSettingsController::class, 'change_banner']);
    Route::post('/settings/change', [WebsiteSettingsController::class, 'update']);
    
    Route::resource('/people', PeopleController::class);

    Route::resource('/quote', QuotesController::class);
    
    Route::resource('/books-category', BooksCategoriesController::class);
    
    Route::resource('articles-category', ArticlesCategories::class);
    
    Route::resource('books', BookController::class);
    
    Route::resource('book-review', BooksReviewsController::class);
    Route::get('book/{book}/review', [BooksReviewsController::class, 'index'])->name('book-review.index');
    Route::delete('review/{review}', [BooksReviewsController::class, 'destroy']);
    Route::post('book/upload', [BookController::class, 'upload_images'])->name('book.upload');


    Route::get('/select2/authors', [select2::class, 'authors'])->name('select2.authors');
    Route::get('/select2/book_category', [select2::class, 'book_category'])->name('select2.book_category');
});