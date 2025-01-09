<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\ApiPost;
use App\Models\Article;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Encoders\AutoEncoder;

class PostsApiController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('can:posts_api_show', only: ['index']),
            new Middleware('can:posts_api_delete', only: ['delete']),
            new Middleware('can:posts_api_approve', only: ['approve']),
        ];
    }
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $posts = ApiPost::query();

            return DataTables::eloquent($posts)
            ->addColumn('action', function($row){
                return 
                "<div class='d-flex align-items-center justify-content-center gap-2'>"
                .
                ( Auth::user()->hasPermissionTo('posts_api_approve') && $row['approved'] == false ?
                "
                   <a href='". route('dashboard.articles.create', ['api_post_id' => $row['id']]) ."'><i class='ri-check-double-line text-success fs-4' type='submit'></i></a>
                " : ''
                )
                .
                ( Auth::user()->hasPermissionTo('posts_api_delete') ?
                "
                    <form id='remove_api_post' class='mb-0' data-id='".$row['id']."' onsubmit='remove_api_post(event, this)'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button class='remove_button' onclick='remove_button(this)' type='button'><i class='ri-delete-bin-5-line text-danger fs-4'></i></button>
                    </form>
                ":""
                )
                .
                "</div>";
            })
            ->editColumn('content', function(ApiPost $posts){
                return truncatePostAndRemoveImages($posts->content, 150);
            })
            ->editColumn('imageUrl', function(ApiPost $posts){
                return "
                    <div class='d-flex align-items-center gap-2'>
                        <img src='" . $posts->imageUrl ."' width='40' height='40' class='rounded-5'>
                    </div>
                ";
            })
            ->editColumn('created_at', function(ApiPost $posts){
                return $posts->created_at->diffForHumans();
            })
            ->rawColumns(['content', 'imageUrl', 'action'])
            ->make(true);
        }
        return view('dashboard.api.posts.index');
    }

    public function delete(Request $request, ApiPost $post)
    {
        $post->delete();
    }
}
