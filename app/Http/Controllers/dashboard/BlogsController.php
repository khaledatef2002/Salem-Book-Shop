<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BlogsController extends Controller
{
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
                "
                    <a href='" . route('dashboard.blog-comments.index', $row['id']) . "'><i class='ri-message-2-line fs-4' type='submit'></i></a>
                    <a href='" . route('dashboard.blog-likes.index', $row['id']) . "'><i class='ri-thumb-up-line fs-4' type='submit'></i></a>
                    <a href='" . route('front.blog.show', $row['id']) . "' target='_blank'><i class='ri-eye-line fs-4' type='submit'></i></a>
                "
                .

                "
                    <form id='remove_blog' data-id='".$row['id']."' onsubmit='remove_blog(event, this)'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button class='remove_button' onclick='remove_button(this)' type='button'><i class='ri-delete-bin-5-line text-danger fs-4'></i></button>
                    </form>
                "
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
            ->editColumn('content', function(Blog $blog){
                return truncatePostAndRemoveImages($blog->content, 150);
            })
            ->rawColumns(['content', 'user', 'action'])
            ->make(true);
        }
        return view('dashboard.blogs.index');
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
    public function destroy(string $id)
    {
        //
    }
}
