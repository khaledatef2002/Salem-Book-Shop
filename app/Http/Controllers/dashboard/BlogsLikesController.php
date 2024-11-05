<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\BlogLike;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BlogsLikesController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $articles = BlogLike::get();
            return DataTables::of($articles)
            ->rawColumns(['action'])
            ->addColumn('action', function($row){
                return 
                "<div class='d-flex align-items-center justify-content-center gap-2'>
                    <form id='remove_like' data-id='".$row['id']."' onsubmit='remove_like(event, this)'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button class='remove_button' onclick='remove_button(this)' type='button'><i class='ri-delete-bin-5-line text-danger fs-4'></i></button>
                    </form>
                </div>";
            })
            ->addColumn('user', function(BlogLike $like){
                return "
                    <div class='d-flex align-items-center gap-2'>
                        <img src='" . asset($like->user->display_image) ."' width='40' height='40' class='rounded-5'>
                        <span>{$like->user->full_name}</span>
                    </div>
                ";
            })
            ->addColumn('blog', function(BlogLike $like){
                return "<a href='" . route('front.blog.show', $like->blog) . "' target='_blank'>" . $like->blog->title . "</a>";
            })
            ->rawColumns(['blog', 'user', 'action'])
            ->make(true);
        }
        return view('dashboard.blogs.likes');
    }

    public function destroy(Request $request, BlogLike $like)
    {
        $like->delete();
    }
}
