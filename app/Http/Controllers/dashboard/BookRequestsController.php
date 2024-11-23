<?php

namespace App\Http\Controllers\dashboard;

use App\BookRequestsStatesType;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            ->addIndexColumn()
            ->addColumn('action', function(BookRequest $request){
                return 
                "<div class='d-flex align-items-center justify-content-center gap-2'>"
                .
                ( Auth::user()->hasPermissionTo('books_requests_delete') && $request->state == BookRequestsStatesType::pending->value ?
                "
                    <form id='cancel_book_request' data-user-id='".$request->user_id."' data-book-id='".$request->book_id."' onsubmit='cancel_book_request(event, this)'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button class='remove_button' onclick='cancel_book_request(this)' type='button'><i class='ri-close-line text-danger fs-4'></i></button>
                    </form>
                    <form id='accept_book_request' data-user-id='".$request->user_id."' data-book-id='".$request->book_id."' onsubmit='accept_book_request(event, this)'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button class='remove_button' onclick='accept_book_request(this)' type='button'><i class='ri-check-double-line text-success fs-4'></i></button>
                    </form>
                ":"")
                .
                ( Auth::user()->hasPermissionTo('books_requests_delete') ?
                "
                    <form id='remove_request' data-user-id='".$request->user_id."' data-book-id='".$request->book_id."' onsubmit='remove_request(event, this)'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button class='remove_button' onclick='remove_button(this)' type='button'><i class='ri-delete-bin-5-line text-danger fs-4'></i></button>
                    </form>
                ":"")
                .
                "</div>";
            })
            ->addColumn('user', function(BookRequest $request){
                return "
                    <div class='d-flex align-items-center gap-2'>
                        <img src='" . $request->user->display_image ."' width='40' height='40' class='rounded-5'>
                        <span>{$request->user->full_name}</span>
                    </div>
                ";
            })
            ->addColumn('book', function(BookRequest $request){
                return "<a href='". route('front.book.show', $request->book->id) ."' target='_blank'>" . $request->book->title . "</a>";
            })
            ->addColumn('state', function(BookRequest $request){
                return match($request->state) {
                    BookRequestsStatesType::pending->value => "<span class='badge bg-warning text-dark px-2 py-1 fs-6'>" . __($request->state) . "</span>",
                    BookRequestsStatesType::approved->value => "<span class='badge bg-success px-2 py-1 fs-6'>" . __($request->state) . "</span>",
                    BookRequestsStatesType::canceled->value => "<span class='badge bg-danger px-2 py-1 fs-6'>" . __($request->state) . "</span>"
                };
            })
            ->rawColumns(['user', 'book', 'state', 'action'])
            ->make(true);
        }
        return view('dashboard.books.requests.index');
    }

    public function cancel(Request $request, Book $book, User $user)
    {
        $bookRequest = BookRequest::where('book_id', $book->id)
            ->where('user_id', $user->id)
            ->first();

        if (!$bookRequest) {
            return response()->json([
                'success' => false,
                'message' => 'Book request not found.',
            ], 404);
        }

        $bookRequest->state = BookRequestsStatesType::canceled->value;
        $bookRequest->save();
    }

    public function accept(Request $request, Book $book, User $user)
    {
        $bookRequest = BookRequest::where('book_id', $book->id)
            ->where('user_id', $user->id)
            ->first();

        if (!$bookRequest) {
            return response()->json([
                'success' => false,
                'message' => 'Book request not found.',
            ], 404);
        }

        $bookRequest->state = BookRequestsStatesType::approved->value;
        $bookRequest->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Book $book, User $user)
    {
        // Attempt to delete the record directly
        $deleted = BookRequest::where('book_id', $book->id)
            ->where('user_id', $user->id)
            ->delete();

        // Check if a record was deleted
        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Book request deleted successfully.',
            ]);
        }

        // If no record was found, return a 404 response
        return response()->json([
            'success' => false,
            'message' => 'Book request not found.',
        ], 404);
    }
}
