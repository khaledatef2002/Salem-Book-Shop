<?php

use App\helper\select2;
use App\Http\Controllers\dashboard\ArticlesCategories;
use App\Http\Controllers\dashboard\ArticlesCommentsController;
use App\Http\Controllers\dashboard\ArticlesController;
use App\Http\Controllers\dashboard\ArticlesLikesController;
use App\Http\Controllers\dashboard\BlogsComents;
use App\Http\Controllers\dashboard\BlogsComentsController;
use App\Http\Controllers\dashboard\BlogsController;
use App\Http\Controllers\dashboard\BlogsLikesController;
use App\Http\Controllers\dashboard\BookController;
use App\Http\Controllers\dashboard\BooksCategoriesController;
use App\Http\Controllers\dashboard\BooksReviewsController;
use App\Http\Controllers\dashboard\ContactsController;
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
    Route::get('/select2/article_category', [select2::class, 'article_category'])->name('select2.article_category');

    Route::resource('articles', ArticlesController::class);
    Route::get('article-comments', [ArticlesCommentsController::class, 'index'])->name('article-comments.index');
    Route::delete('article-comments/delete/{comment}', [ArticlesCommentsController::class, 'destroy']);
    Route::get('article-likes', [ArticlesLikesController::class, 'index'])->name('article-likes.index');
    Route::delete('article-likes/delete/{like}', [ArticlesLikesController::class, 'destroy']);
    Route::post('ckEditorUploadImage', [ArticlesController::class, 'uploadImage']);
    Route::post('ckEditorRemoveImage', [ArticlesController::class, 'removeImage']);

    Route::resource('blogs', BlogsController::class);
    Route::get('blog-comments', [BlogsComentsController::class, 'index'])->name('blog-comments.index');
    Route::delete('blog-comments/delete/{comment}', [BlogsComentsController::class, 'destroy']);
    Route::get('blog-likes', [BlogsLikesController::class, 'index'])->name('blog-likes.index');
    Route::delete('blog-likes/delete/{like}', [BlogsLikesController::class, 'destroy']);

    Route::resource('contacts', ContactsController::class);
});