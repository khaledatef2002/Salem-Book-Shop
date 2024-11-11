<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class GenerateArticleSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:generate-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generating slugs for existing articles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $articles = Article::where('slug', "")->get();

        foreach ($articles as $article) {
            // Format the created_at date
            $date = $article->created_at ? $article->created_at->format('Y-m-d H:i') : now()->format('Y-m-d H:i');
            
            $slug = [];

            foreach (LaravelLocalization::getSupportedLocales() as $locale)
            {
                $slug[$locale['locale']] = Str::of($article->getTranslation('title', $locale['locale']) . '-' . $date)->trim()->lower()->replace(' ', '-');
            }

            $article->update([
                'slug' => $slug
            ]);

            $this->info("Slug generated for Article ID {$article->id}:");
        }

        $this->info('Slugs generated for all articles.');
    }
}
