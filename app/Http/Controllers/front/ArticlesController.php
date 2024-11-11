<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleComment;
use App\Models\ArticleLike;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class ArticlesController extends Controller implements HasMiddleware
{
    const page_limit = 13;

    public static function middleware()
    {
        return [
            new Middleware('auth', only: ['likeAction', 'addComment', 'deleteComment'])
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

        foreach($articles as $article)
        {
            $article->content = strip_tags(truncatePostAndRemoveImages($article->content));
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

    public function show($slug)
    {
        $article = Article::where('slug->en', $slug)->orWhere('slug->ar', $slug)->firstOrFail();

        $categories = ArticleCategory::get();
        $comments = $article->comments()->paginate(5);
        return view('front.news.single-article', compact('article', 'categories', 'comments'));
    }

    public function addComment(Request $request)
    {
        $request->validate([
            'article_id' => ['required', 'exists:articles,id'],
            'comment' => ['required', 'min:1', 'max:400']
        ]);
        
        $user_id = auth()->user()->id;

        ArticleComment::create([
            'article_id' => $request->article_id,
            'user_id' => $user_id,
            'comment' => $request->comment
        ]);

        $article = Article::find($request->article_id)->first();

        return view('front.parts.single-article-comments', compact('article'));
    }

    public function deleteComment(Request $request)
    {
        $user_id = Auth::user()->id;
        $request->validate([
            'comment_id' => ['required', 'exists:article_comments,id'],
        ]);
        
        ArticleComment::where('id', $request->comment_id)->where('user_id', $user_id)->first()->delete();
    }

    public function editComment(Request $request)
    {
        $user_id = Auth::user()->id;
        $request->validate([
            'comment_id' => ['required', 'exists:article_comments,id'],
            'comment' => ['required', 'min:1', 'max:400']
        ]);
        
        ArticleComment::where('id', $request->comment_id)->where('user_id', $user_id)->first()->update([
            'comment' => $request->comment
        ]);

        return $request->comment;
    }
}
