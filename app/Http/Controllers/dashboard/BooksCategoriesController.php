<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\BooksCategory;
use CodeZero\UniqueTranslation\UniqueTranslationRule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Yajra\DataTables\Facades\DataTables;

class BooksCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $quotes = BooksCategory::get();
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
                    <form id='remove_book_category' data-id='".$row['id']."' onsubmit='remove_book_category(event, this)'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button class='remove_button' onclick='remove_button(this)' type='button'><i class='ri-delete-bin-5-line text-danger fs-4'></i></button>
                    </form>
                "
                .
                "</div>";
            })
            ->editColumn('name', function(BooksCategory $category){
                return $category->name;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('dashboard.books.categories');
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
            'name.*' => ['required', UniqueTranslationRule::for('books_categories'), 'min:2']
        ]);

        BooksCategory::create($data);
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
    public function edit(BooksCategory $books_category)
    {
        return response()->json($books_category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BooksCategory $books_category)
    {
        $data = $request->validate([
            'name' => ['required', 'array'],
            'name.*' => ['required', UniqueTranslationRule::for('books_categories')->ignore($books_category->id), 'min:2']
        ]);

        $books_category->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BooksCategory $books_category)
    {
        $books_category->delete();
    }
}
