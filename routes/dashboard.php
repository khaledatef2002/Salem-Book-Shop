<?php

use App\helper\select2;
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
    Route::get('/select2/authors', [select2::class, 'authors'])->name('select2.authors');
});