<?php

namespace App\Http\Controllers\dashboard;

use App\ApproavedStatusType;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BlogsController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('can:blogs_show', only: ['index']),
            new Middleware('can:blogs_delete', only: ['destroy']),
            new Middleware('can:blogs_approve', only: ['approve'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $articles = Blog::get();
            return DataTables::of($articles)
            ->rawColumns(['action'])
            ->addColumn('action', function($row){
                return 
                "<div class='d-flex align-items-center justify-content-center gap-2'>"
                .
                ( Auth::user()->hasPermissionTo('blogs_comments_show') ?
                "<a href='" . route('dashboard.blog-comments.index', $row['id']) . "'><i class='ri-message-2-line fs-4' type='submit'></i></a>"
                :"")
                . 
                ( Auth::user()->hasPermissionTo('blogs_likes_show') ?
                "<a href='" . route('dashboard.blog-likes.index', $row['id']) . "'><i class='ri-thumb-up-line fs-4' type='submit'></i></a>"
                :"")
                . 
                "<a href='" . route('front.blog.show', $row['id']) . "' target='_blank'><i class='ri-eye-line fs-4' type='submit'></i></a>"
                .
                ( Auth::user()->hasPermissionTo('blogs_approve') ?
                (

                    match ($row['approaved'])
                    {
                        ApproavedStatusType::pending->value => "<button class='remove_button' title='approave' onclick='approave_blog({$row['id']})'><i class='ri-check-double-line fs-4 text-success'></i></button>",
                        default => ''
                    }

                ):"")
                .
                ( Auth::user()->hasPermissionTo('blogs_delete') ?
                "
                    <form id='remove_blog' data-id='".$row['id']."' onsubmit='remove_blog(event, this)'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button class='remove_button' onclick='remove_button(this)' type='button'><i class='ri-delete-bin-5-line text-danger fs-4'></i></button>
                    </form>
                ":"")
                .
                "</div>";
            })
            ->addColumn('user', function(Blog $blog){
                return "
                    <div class='d-flex align-items-center gap-2'>
                        <img src='" . asset($blog->user->display_image) ."' width='40' height='40' class='rounded-5'>
                        <span>{$blog->user->full_name}</span>
                    </div>
                ";
            })
            ->addColumn('status', function(Blog $blog){
                return ($blog->approaved == ApproavedStatusType::pending->value) ? "<span class='badge bg-warning'>". __('dashboard.pending') ."</span>" : "<span class='badge bg-success'>". __('dashboard.approaved') ."</span>";
            })
            ->editColumn('content', function(Blog $blog){
                return truncatePostAndRemoveImages($blog->content, 150);
            })
            ->rawColumns(['content','status', 'user', 'action'])
            ->make(true);
        }
        return view('dashboard.blogs.index');
    }

    public function appoave(Request $request, Blog $blog)
    {
        $blog->update([
            'approaved' => ApproavedStatusType::approaved->value
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
    }
}
