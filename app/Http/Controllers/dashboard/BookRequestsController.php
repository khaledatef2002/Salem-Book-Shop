<?php

namespace App\Http\Controllers\dashboard;

use App\BookRequestsStatesType;
use App\Http\Controllers\Controller;
use App\Mail\BookRequestMail;
use App\Models\Book;
use App\Models\BookRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class BookRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $quotes = BookRequest::get();
            return DataTables::of($quotes)
            ->rawColumns(['action'])
            ->addColumn('action', function(BookRequest $book_request){
                return 
                "<div class='d-flex align-items-center justify-content-center gap-2'>"
                .
                ( Auth::user()->hasPermissionTo('books_requests_delete') && $book_request->state == BookRequestsStatesType::pending->value ?
                "
                    <form id='cancel_book_request' data-id='".$book_request->id."' onsubmit='cancel_book_request(event, this)'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button class='remove_button' onclick='cancel_book_request(this)' type='button'><i class='ri-close-line text-danger fs-4'></i></button>
                    </form>
                    <form id='accept_book_request' data-id='".$book_request->id."' onsubmit='accept_book_request(event, this)'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button class='remove_button' onclick='accept_book_request(this)' type='button'><i class='ri-check-double-line text-success fs-4'></i></button>
                    </form>
                ":"")
                .
                ( Auth::user()->hasPermissionTo('books_requests_delete') ?
                "
                    <form id='remove_request' data-id='".$book_request->id."' onsubmit='remove_request(event, this)'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button class='remove_button' onclick='remove_button(this)' type='button'><i class='ri-delete-bin-5-line text-danger fs-4'></i></button>
                    </form>
                ":"")
                .
                "</div>";
            })
            ->addColumn('user', function(BookRequest $book_request){
                return "
                    <div class='d-flex align-items-center gap-2'>
                        <img src='" . $book_request->user->display_image ."' width='40' height='40' class='rounded-5'>
                        <span>{$book_request->user->full_name}</span>
                    </div>
                ";
            })
            ->addColumn('book', function(BookRequest $book_request){
                return "<a href='". route('front.book.show', $book_request->book->id) ."' target='_blank'>" . $book_request->book->title . "</a>";
            })
            ->addColumn('state', function(BookRequest $book_request){
                return match($book_request->state) {
                    BookRequestsStatesType::pending->value => "<span class='badge bg-warning text-dark px-2 py-1 fs-6'>" . __($book_request->state) . "</span>",
                    BookRequestsStatesType::approved->value => "<span class='badge bg-success px-2 py-1 fs-6'>" . __($book_request->state) . "</span>",
                    BookRequestsStatesType::canceled->value => "<span class='badge bg-danger px-2 py-1 fs-6'>" . __($book_request->state) . "</span>"
                };
            })
            ->rawColumns(['user', 'book', 'state', 'action'])
            ->make(true);
        }
        return view('dashboard.books.requests.index');
    }

    public function cancel(Request $request, BookRequest $book_request)
    {
        $book_request->state = BookRequestsStatesType::canceled->value;
        $book_request->save();

        $email = $book_request->user->email; // Set the recipient's email address
        Mail::to($email)->send(new BookRequestMail($book_request->book, false));
    }

    public function accept(Request $request, BookRequest $book_request)
    {
        $book_request->state = BookRequestsStatesType::approved->value;
        $book_request->save();

        $email = $book_request->user->email; // Set the recipient's email address
        Mail::to($email)->send(new BookRequestMail($book_request->book, true));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, BookRequest $book_request)
    {
        // Attempt to delete the record directly
        $book_request->delete();
    }
}
