<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ArticlesCategories extends Controller
{
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
                "
                    <button class='remove_button' onclick='openEditCategory({$row['id']})'><i class='ri-settings-5-line fs-4' type='submit'></i></button>
                "
                .

                "
                    <form id='remove_article_category' data-id='".$row['id']."' onsubmit='remove_article_category(event, this)'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button class='remove_button' onclick='remove_button(this)' type='button'><i class='ri-delete-bin-5-line text-danger fs-4'></i></button>
                    </form>
                "
                .
                "</div>";
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
        $request->validate([
            'name' => ['required', 'unique:article_categories,name', 'min:2', 'max:20']
        ]);

        ArticleCategory::create([
            'name' => $request->name
        ]);
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
        $request->validate([
            'name' => ['required','unique:article_categories,name,' . $articles_category->id, 'min:2', 'max:20']
        ]);

        $articles_category->update([
            'name' => $request->name
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ArticleCategory $articles_category)
    {
        $articles_category->delete();
    }
}
