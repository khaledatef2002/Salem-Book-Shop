<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private const page_limit = 13;

    public function index(Request $request)
    {
        if($request->category_id)
        {
            $books = Book::where('category_id', $request->category_id)->paginate(self::page_limit);
        }
        else
        {
            $books = Book::paginate(self::page_limit);
        }

        return view('front.books.view-all', compact('books'));
    }

    public function getAllBooksAjax(Request $request)
    {
        $limit = $request->query('limit', self::page_limit);
        $search = $request->query('search', '');
        $categories = $request->query('categories', []);

        $books = Book::where('title', 'like' , "%$search%");

        if($categories)
        {
            $books = $books->whereIn('category_id', $categories);
        }

        switch($request->query('sort'))
        {
            case 'publish-old':
                $books->orderBy('created_at');
                break;
            case 'name-a':
                $books->orderBy('title');
                break;
            case 'name-z':
                $books->orderByDesc('title');
                break;
            case 'rating-highest':
                $books->withCount([
                    'bookReviews as book_review_avg_rating' => function ($query) {
                        $query->select(\DB::raw('coalesce(avg(review_star), 0)'));
                    }
                ])
                ->orderByDesc('book_review_avg_rating');
                break;
            case 'rating-highest':
                $books->withCount([
                    'bookReviews as book_review_avg_rating' => function ($query) {
                        $query->select(\DB::raw('coalesce(avg(review_star), 0)'));
                    }
                ])
                ->orderBy('book_review_avg_rating');
                break;
            default:
                $books->orderByDesc('created_at');
        }

        $books = $books->paginate($limit);

        return view('front.parts.books-list', compact('books'));
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
    public function show(Book $book)
    {
        return view('front.books.single-book', compact('book'));
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
