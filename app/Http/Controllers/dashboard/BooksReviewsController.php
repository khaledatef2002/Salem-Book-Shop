<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookReview;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BooksReviewsController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('can:books_reviews_show', only: ['index']),
            new Middleware('can:books_reviews_delete', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, int $book)
    {
        $book_title = Book::find($book)->get('title')->first()->title;
        if($request->ajax())
        {
            $quotes = BookReview::where('book_id', $book)->get();
            return DataTables::of($quotes)
            ->rawColumns(['action'])
            ->addColumn('action', function($row){
                return Auth::user()->hasPermissionTo('books_reviews_delete') ?
                "
                    <form id='remove_book_review' data-id='".$row['id']."' onsubmit='remove_book_review(event, this)'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button class='remove_button' onclick='remove_button(this)' type='button'><i class='ri-delete-bin-5-line text-danger fs-4'></i></button>
                    </form>
                " : "";
            })
            ->editColumn('book', function(BookReview $review){
                return $review->book->title;
            })
            ->editColumn('user', function(BookReview $review){
                return "
                    <div class='d-flex align-items-center gap-2'>
                        <img src='" . asset($review->user->display_image) ."' width='40' height='40' class='rounded-5'>
                        <span>{$review->user->full_name}</span>
                    </div>
                ";
            })
            ->editColumn('stars', function(BookReview $review){
                $stars = "";
                for($i = 0; $i < $review->review_star; $i++)
                {
                    $stars .= "<i class='ri-star-fill text-warning fs-5'></i>";
                }
                for($i = 0; $i < 5 - $review->review_star; $i++)
                {
                    $stars .= "<i class='ri-star-line fs-5'></i>";
                }
                return $stars;
            })
            ->rawColumns(['user', 'stars', 'action'])
            ->make(true);
        }
        return view('dashboard.books.reviews', compact('book_title'));
    }

    public function destroy(BookReview $review)
    {
        $review->delete();
    }
}
