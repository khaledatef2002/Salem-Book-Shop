<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\ArticleLike;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ArticlesLikesController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('can:articles_likes_show', only: ['index']),
            new Middleware('can:articles_likes_delete', only: ['destroy']),
        ];
    }
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $articles = ArticleLike::get();
            return DataTables::of($articles)
            ->rawColumns(['action'])
            ->addColumn('action', function($row){
                return Auth::user()->hasPermissionTo('articles_likes_delete') ?
                "<div class='d-flex align-items-center justify-content-center gap-2'>
                    <form id='remove_like' data-id='".$row['id']."' onsubmit='remove_like(event, this)'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button class='remove_button' onclick='remove_button(this)' type='button'><i class='ri-delete-bin-5-line text-danger fs-4'></i></button>
                    </form>
                </div>" : "";
            })
            ->addColumn('user', function(ArticleLike $like){
                return "
                    <div class='d-flex align-items-center gap-2'>
                        <img src='" . asset($like->user->display_image) ."' width='40' height='40' class='rounded-5'>
                        <span>{$like->user->full_name}</span>
                    </div>
                ";
            })
            ->addColumn('article', function(ArticleLike $like){
                return "<a href='" . route('front.article.show', $like->article) . "' target='_blank'>" . $like->article->title . "</a>";
            })
            ->rawColumns(['article', 'user', 'action'])
            ->make(true);
        }
        return view('dashboard.articles.likes');
    }

    public function destroy(Request $request, ArticleLike $like)
    {
        $like->delete();
    }
}
