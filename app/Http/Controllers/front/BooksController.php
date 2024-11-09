<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookReview;
use App\Models\TemporaryLink;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\ImageManager;
use Spatie\PdfToImage\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

        switch($request->query('sort_by'))
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
        $reviews = $book->reviews()->paginate(5);
        $pagesCount = $this->getPagesCount($book);
        return view('front.books.single-book', compact('book', 'reviews', 'pagesCount'));
    }

    public function addReview(Request $request)
    {
        $request->validate([
            'review_star' => ['required', 'min:0', 'max:5', 'numeric'],
            'review_text' => ['required', 'max:70'],
            'book_id' => ['required', 'exists:books,id'],
        ]);

        $user_id = auth()->user()->id;

        $check_review_exist = BookReview::where('book_id', $request->book_id)->where('user_id', $user_id)->count();

        if($check_review_exist)
        {
            return response()->json(['errors' => ['invalid' => [__('custom-errors.books.already-reviews')]]], 422);
        }

        $review = BookReview::create([
            'book_id' => $request->book_id,
            'review_star' => $request->review_star,
            'review_text' => $request->review_text,
            'user_id' => $user_id
        ]);
        

        return view('front.parts.book-auth-review', ['review' => $review]);
    }

    public function deleteReview(Request $request)
    {
        $request->validate([
            'book_id' => ['required', 'exists:books,id']
        ]);
        $user_id = auth()->user()->id;
        $review = BookReview::where('book_id', $request->book_id)->where('user_id', $user_id)->delete();
    }

    public function getReview(Request $request)
    {
        $request->validate([
            'book_id' => ['required', 'exists:books,id']
        ]);
        $user_id = auth()->user()->id;
        $get_review = BookReview::where('book_id', $request->book_id)->where('user_id', $user_id)->first();
        return json_encode($get_review);
    }

    public function updateReview(Request $request)
    {
        $request->validate([
            'review_star' => ['required', 'min:0', 'max:5', 'numeric'],
            'review_text' => ['required', 'max:70'],
            'book_id' => ['required', 'exists:books,id'],
        ]);

        $user_id = auth()->user()->id;

        $review = BookReview::where('book_id', $request->book_id)->where('user_id', $user_id)->first();

        $review->review_star = $request->review_star;
        $review->review_text = $request->review_text;

        $review->save();

        return view('front.parts.book-auth-review', ['review' => $review]);
    }

    public function download($id)
    {
        $book = Book::findOrFail($id);
        if (!$book->downloadable) {
            die("This book isn't downloadable");
        }
        $pdfPath = $book->source;
        if (!Storage::disk('public')->exists($pdfPath)) {
            die("Invalid book source");
        }
        return Storage::disk('public')->download($pdfPath);
    }

    public function read($id, $page)
    {
        // putenv('PATH=' . getenv('PATH') . ';C:\Program Files\gs\gs10.04.0\bin');
    
        // // Retrieve the book
        // $book = Book::findOrFail($id);

        // if(!Storage::disk('local')->exists("/books_images/" . $book->id))
        // {
        //     Storage::disk('local')->makeDirectory("/books_images/" . $book->id);
        // }

        // if(!Storage::disk('local')->exists("/books_images/{$book->id}/{$page}.jpg"))
        // {
        //     // Define the PDF path in the private folder
        //     $pdfPath = storage_path("app/private/{$book->source}");
    
        //     $pdf = new \Drenso\PdfToImage\Pdf($pdfPath);
        //     $pdf->setPage($page)
        //     ->saveImage(storage_path("app/private/books_images/{$book->id}/{$page}.jpg"));
        // }
        // $image = Storage::disk('local')->get("/books_images/{$book->id}/{$page}.jpg");
        // return response($image, 200)->header('Content-Type', 'image/jpeg');

        // Retrieve the book
        $book = Book::findOrFail($id);

        if(!Storage::disk('public')->exists("/books_images/" . $book->id))
        {
            Storage::disk('public')->makeDirectory("/books_images/" . $book->id);
        }

        $pdf = Storage::disk('public')->get($book->source);
        return response($pdf, 200)->header('Content-Type', 'application/pdf');
    }

    public function getImages(Request $request)
    {
        $book = Book::findOrFail($request->id);
        $page = $request->page;

        $pageFile = storage_path("app/public/pdf-images/{$book->id}/page-$page.jpg");
        if (file_exists($pageFile)) {
            $imageData = base64_encode(file_get_contents($pageFile));
            return response()->json(['image' => $imageData]);
        }

        // Create output directory if it doesn't exist
        $outputDirectory = storage_path("app/public/pdf-images/{$book->id}/");
        if (!file_exists($outputDirectory)) {
            mkdir($outputDirectory, 0777, true);
        }

        // Convert the specific page to an image
        $path = Storage::disk('public')->path($book->source);
        $pdf = new \Spatie\PdfToImage\Pdf($path);
        echo $page;
        $pdf->setPage($page);
        $outputPath = $outputDirectory . "page-$page.jpg";
        $pdf->saveImage($outputPath);

        $imageData = base64_encode(file_get_contents($pageFile));
        return response()->json(['image' => $imageData]);
    }

    private function getPagesCount(Book $book)
    {
        $path = Storage::disk('public')->path($book->source);
        $pdf = new \Spatie\PdfToImage\Pdf($path);

        return $pdf->getNumberOfPages();
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
