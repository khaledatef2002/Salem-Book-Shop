<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleComment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ArticlesCommentsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $articles = ArticleComment::get();
            return DataTables::of($articles)
            ->rawColumns(['action'])
            ->addColumn('action', function($row){
                return 
                "<div class='d-flex align-items-center justify-content-center gap-2'>
                    <form id='remove_comment' data-id='".$row['id']."' onsubmit='remove_comment(event, this)'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button class='remove_button' onclick='remove_button(this)' type='button'><i class='ri-delete-bin-5-line text-danger fs-4'></i></button>
                    </form>
                </div>";
            })
            ->addColumn('user', function(ArticleComment $comment){
                return "
                    <div class='d-flex align-items-center gap-2'>
                        <img src='" . asset($comment->user->display_image) ."' width='40' height='40' class='rounded-5'>
                        <span>{$comment->user->full_name}</span>
                    </div>
                ";
            })
            ->addColumn('article', function(ArticleComment $comment){
                return "<a href='" . route('front.article.show', $comment->article) . "' target='_blank'>" . $comment->article->title . "</a>";
            })
            ->rawColumns(['article', 'user', 'action'])
            ->make(true);
        }
        return view('dashboard.articles.comments');
    }

    public function destroy(Request $request, ArticleComment $comment)
    {
        $comment->delete();
    }
}
