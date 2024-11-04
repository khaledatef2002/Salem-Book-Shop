<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $articles = Article::get();
            return DataTables::of($articles)
            ->rawColumns(['action'])
            ->addColumn('action', function($row){
                return 
                "<div class='d-flex align-items-center justify-content-center gap-2'>"
                .
                "
                    <a href='" . route('dashboard.article-comments.index', $row['id']) . "'><i class='ri-message-2-line fs-4' type='submit'></i></a>
                    <a href='" . route('dashboard.article-likes.index', $row['id']) . "'><i class='ri-thumb-up-line fs-4' type='submit'></i></a>
                    <a href='" . route('front.article.show', $row['id']) . "' target='_blank'><i class='ri-eye-line fs-4' type='submit'></i></a>
                    <a href='" . route('dashboard.books.edit', $row) . "'><i class='ri-settings-5-line fs-4' type='submit'></i></a>    
                "
                .

                "
                    <form id='remove_book' data-id='".$row['id']."' onsubmit='remove_book(event, this)'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button class='remove_button' onclick='remove_button(this)' type='button'><i class='ri-delete-bin-5-line text-danger fs-4'></i></button>
                    </form>
                "
                .
                "</div>";
            })
            ->addColumn('user', function(Article $article){
                return "
                    <div class='d-flex align-items-center gap-2'>
                        <img src='" . asset($article->user->display_image) ."' width='40' height='40' class='rounded-5'>
                        <span>{$article->user->full_name}</span>
                    </div>
                ";
            })
            ->addColumn('likes', function(Article $article){
                return $article->likes()->count();
            })
            ->addColumn('comments', function(Article $article){
                return $article->comments()->count();
            })
            ->editColumn('content', function(Article $article){
                return truncatePostAndRemoveImages($article->content, 150);
            })
            ->editColumn('cover', function(Article $article){
                return "<a href='" . asset('storage/' . $article->cover) . "' target='_blank'><img src='" . asset('storage/' . $article->cover) ."' width='80' class='rounded-2'></a>";
            })
            ->rawColumns(['cover', 'content', 'user', 'action'])
            ->make(true);
        }
        return view('dashboard.articles.index');
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
    public function destroy(Article $article)
    {
        if(Storage::disk('public')->exists($article->cover))
        {
            Storage::disk('public')->delete($article->cover);
        }
    }
}
