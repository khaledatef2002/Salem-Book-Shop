<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleLike;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ArticlesController extends Controller implements HasMiddleware
{
    const page_limit = 13;

    public static function middleware()
    {
        return [
            new Middleware('auth', only: ['likeAction'])
        ];
    }

    public function index(Request $request)
    {
        if($request->category_id)
        {
            $articles = Article::where('category_id', $request->category_id)->orderByDesc('created_at')->paginate(self::page_limit);
        }
        else
        {
            $articles = Article::orderByDesc('created_at')->paginate(self::page_limit);
        }
        $categories = ArticleCategory::get();
        return view('front.news.view-all', compact('articles', 'categories'));
    }

    public function getAllArticlesAjax(Request $request)
    {
        $limit = $request->query('limit', self::page_limit);
        $search = $request->query('search', '');
        $categories = $request->query('categories', []);

        $articles = Article::where('title', 'like' , "%$search%");

        if($categories)
        {
            $articles = $articles->whereIn('category_id', $categories);
        }

        switch($request->query('sort_by'))
        {
            case 'publish-old':
                $articles->orderBy('created_at');
                break;
            case 'title-a':
                $articles->orderBy('title');
                break;
            case 'title-z':
                $articles->orderByDesc('title');
                break;
            default:
                $articles->orderByDesc('created_at');
        }

        $articles = $articles->paginate($limit);

        return view('front.parts.articles-list', compact('articles'));
    }

    public function likeAction(Request $request)
    {
        $request->validate([
            'id' => 'exists:articles'
        ]);

        $like = ArticleLike::where('article_id', $request->id)->where('user_id', auth()->user()->id);

        $state = __('custom.liked');

        if($like->count() > 0)
        {
            $like->delete();
            $state = __('custom.like');
        }
        else
        {
            ArticleLike::create([
                'article_id' => $request->id,
                'user_id' => auth()->user()->id
            ]);
        }
        $likes = ArticleLike::where('article_id', $request->id)->count();

        return json_encode(['state' => $state, 'likes_count' => $likes]);
    }

    public function show(Article $article)
    {
        $categories = ArticleCategory::get();
        return view('front.news.single-article', compact('article', 'categories'));
    }
}
