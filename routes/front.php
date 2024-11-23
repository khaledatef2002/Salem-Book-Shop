<?php

use App\Http\Controllers\front\BlogsController;
use App\Http\Controllers\front\ArticlesController;
use App\Http\Controllers\front\BooksController;
use App\Http\Controllers\front\EventsController;
use App\Http\Controllers\front\HomeController;
use App\Http\Controllers\front\NewsController;
use App\Http\Controllers\front\QuotesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::name('front.')->group(function(){
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/about', [HomeController::class, 'about'])->name('about');
    
    Route::resource('book', BooksController::class);
    Route::get('/getAllBooksAjax', [BooksController::class, 'getAllBooksAjax']);
    Route::get('books/{id}/download', [BooksController::class, 'download'])->name('books.download');
    Route::get('/books/{id}/read/{page}', [BooksController::class, 'read'])->name('books.read');
    
    Route::get('/getAllEventsAjax', [EventsController::class, 'getAllEventsAjax']);

    Route::resource('event', EventsController::class);

    Route::middleware('auth')->group(function(){
        Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
        Route::post('/contact', [HomeController::class, 'add_contact']);

        Route::post('book/review', [BooksController::class, 'addReview']);
        Route::post('book/editReview', [BooksController::class, 'updateReview']);
        Route::get('book/review/data', [BooksController::class, 'getReview']);
        Route::delete('book/review/delete', [BooksController::class, 'deleteReview']);
        Route::get('book/unlock/{book}', [BooksController::class, 'request_unlock']);
        Route::get('book/unlock/cancel/{book}', [BooksController::class, 'cancel_request_unlock']);

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
        Route::get('/profile/unlocked_books', [ProfileController::class, 'books'])->name('profile.unlocked_books');
        Route::post('/profile/general_info', [ProfileController::class, 'update'])->name('profile.general');
        Route::post('/profile/update_password', [ProfileController::class, 'update_password'])->name('profile.password');
    
        Route::post('event/auth/attend', [EventsController::class, 'attend_auth'])->middleware('authEventAction');
        Route::post('event/auth/unAttend', [EventsController::class, 'unattend_auth'])->middleware('authEventAction');
        Route::post('event/review', [EventsController::class, 'addReview']);
        Route::delete('event/review/delete', [EventsController::class, 'deleteReview']);
        Route::get('event/review/data', [EventsController::class, 'getReview']);
        Route::post('event/editReview', [EventsController::class, 'updateReview']);
    });

    Route::resource('article', ArticlesController::class)->only('index');
    Route::get('/article/{slug}', [ArticlesController::class, 'show'])->name('article.show');
    Route::get('/getAllArticlesAjax', [ArticlesController::class, 'getAllArticlesAjax']);
    Route::post('article/like', [ArticlesController::class, 'likeAction']);
    Route::post('article/comment/add', [ArticlesController::class, 'addComment']);
    Route::delete('article/comment/delete', [ArticlesController::class, 'deleteComment']);
    Route::post('article/comment/edit', [ArticlesController::class, 'editComment']);
    
    Route::resource('blog', BlogsController::class);
    Route::post('blog/like', [BlogsController::class, 'likeAction']);
    Route::get('/getAllBlogsAjax', [BlogsController::class, 'getAllBlogsAjax']);
    Route::post('ckEditorUploadImage', [BlogsController::class, 'uploadImage']);
    Route::post('blog/comment/add', [BlogsController::class, 'addComment']);
    Route::delete('blog/comment/delete', [BlogsController::class, 'deleteComment']);
    Route::post('blog/comment/edit', [BlogsController::class, 'editComment']);


    Route::resource('quote', QuotesController::class);
    Route::get('/getAllQuotesAjax', [QuotesController::class, 'getAllQuotesAjax']);
    Route::post('quotes/like', [QuotesController::class, 'likeAction']);

    Route::post('/pdf/image', [BooksController::class, 'getImages']);
});