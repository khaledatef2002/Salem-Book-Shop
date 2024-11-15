<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\ArticleCategory;
use CodeZero\UniqueTranslation\UniqueTranslationRule;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Yajra\DataTables\Facades\DataTables;

class ArticlesCategories extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('can:articles_show', only: ['index']),
            new Middleware('can:articles_edit', only: ['edit', 'update']),
            new Middleware('can:articles_delete', only: ['destroy']),
            new Middleware('can:articles_create', only: ['store']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $quotes = ArticleCategory::get();
            return DataTables::of($quotes)
            ->rawColumns(['action'])
            ->addColumn('action', function($row){
                return 
                "<div class='d-flex align-items-center justify-content-center gap-2'>"
                .
                ( Auth::user()->hasPermissionTo('articles_categories_edit') ?
                "
                    <button class='remove_button' onclick='openEditCategory({$row['id']})'><i class='ri-settings-5-line fs-4' type='submit'></i></button>
                ":"")
                .
                ( Auth::user()->hasPermissionTo('articles_categories_delete') ?
                "
                    <form id='remove_article_category' data-id='".$row['id']."' onsubmit='remove_article_category(event, this)'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button class='remove_button' onclick='remove_button(this)' type='button'><i class='ri-delete-bin-5-line text-danger fs-4'></i></button>
                    </form>
                ":"")
                .
                "</div>";
            })
            ->editColumn('name', function(ArticleCategory $category){
                return $category->name;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('dashboard.articles.categories');
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
        $data = $request->validate([
            'name' => ['required', 'array'],
            'name.*' => ['required', UniqueTranslationRule::for('article_categories'), 'min:2']
        ]);

        ArticleCategory::create($data);
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
    public function edit(ArticleCategory $articles_category)
    {
        return response()->json($articles_category);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ArticleCategory $articles_category)
    {
        $data = $request->validate([
            'name' => ['required', 'array'],
            'name.*' => ['required', UniqueTranslationRule::for('article_categories')->ignore($articles_category->id), 'min:2']
        ]);

        $articles_category->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ArticleCategory $articles_category)
    {
        $articles_category->delete();
    }
}
