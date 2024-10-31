<?php

use App\Http\Controllers\dashboard\HomeController;
use App\Http\Controllers\dashboard\WebsiteSettingsController;
use Illuminate\Support\Facades\Route;

Route::name('dashboard.')->middleware('auth', 'admin')->prefix('dashboard')->group(function(){
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::resource('website_setting', WebsiteSettingsController::class);

    Route::post('/settings/change-logo', [WebsiteSettingsController::class, 'change_logo']);
    Route::post('/settings/change-banner', [WebsiteSettingsController::class, 'change_banner']);
    Route::post('/settings/change', [WebsiteSettingsController::class, 'update']);
});