<?php

namespace App\Providers;

use App\Models\ArticleCategory;
use App\Models\BooksCategory;
use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share('book_categories', BooksCategory::get(['id', 'name']));
        View::share('website_settings', WebsiteSetting::first());
        View::share('news_categories', ArticleCategory::get(['id', 'name']));
    }
}
