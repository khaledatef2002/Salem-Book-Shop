<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Yajra\DataTables\Facades\DataTables;

class BlogsComentsController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('can:blogs_comments_show', only: ['index']),
            new middleware('can:blogs_comments_delete', only: ['destroy']),
        ];
    }
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $articles = BlogComment::get();
            return DataTables::of($articles)
            ->rawColumns(['action'])
            ->addColumn('action', function($row){
                return ( Auth::user()->hasPermissionTo('blogs_comments_delete') ?
                "<div class='d-flex align-items-center justify-content-center gap-2'>
                    <form id='remove_comment' data-id='".$row['id']."' onsubmit='remove_comment(event, this)'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button class='remove_button' onclick='remove_button(this)' type='button'><i class='ri-delete-bin-5-line text-danger fs-4'></i></button>
                    </form>
                </div>":"");
            })
            ->addColumn('user', function(BlogComment $comment){
                return "
                    <div class='d-flex align-items-center gap-2'>
                        <img src='" . asset($comment->user->display_image) ."' width='40' height='40' class='rounded-5'>
                        <span>{$comment->user->full_name}</span>
                    </div>
                ";
            })
            ->addColumn('blog', function(BlogComment $comment){
                return "<a href='" . route('front.blogs.show', $comment->blog) . "' target='_blank'>" . $comment->blog->title . "</a>";
            })
            ->rawColumns(['blog', 'user', 'action'])
            ->make(true);
        }
        return view('dashboard.blogs.comments');
    }

    public function destroy(Request $request, BlogComment $comment)
    {
        $comment->delete();
    }
}
