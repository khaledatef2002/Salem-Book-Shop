<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookImage;
use App\PeopleType;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\ImageManager;
use Intervention\Image\Encoders\AutoEncoder;

class BookController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('can:books_show', only: ['index']),
            new Middleware('can:books_edit', only: ['edit', 'store', 'upload_images']),
            new Middleware('can:books_delete', only: ['destroy']),
            new Middleware('can:books_create', only: ['store', 'create', 'upload_images']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $quotes = Book::get();
            return DataTables::of($quotes)
            ->rawColumns(['action'])
            ->addColumn('action', function($row){
                return 
                "<div class='d-flex align-items-center justify-content-center gap-2'>"
                .
                ( Auth::user()->hasPermissionTo('books_reviews_show') ?
                "
                    <a href='" . route('dashboard.book-review.index', $row['id']) . "'><i class='ri-message-2-line fs-4' type='submit'></i></a>
                ":"")
                .
                ( Auth::user()->hasPermissionTo('books_edit') ?
                "<a href='" . route('dashboard.books.edit', $row) . "'><i class='ri-settings-5-line fs-4' type='submit'></i></a>
                ":"")
                .
                ( Auth::user()->hasPermissionTo('books_delete') ?
                "
                    <form id='remove_book' data-id='".$row['id']."' onsubmit='remove_book(event, this)'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button class='remove_button' onclick='remove_button(this)' type='button'><i class='ri-delete-bin-5-line text-danger fs-4'></i></button>
                    </form>
                ":"")
                .
                "</div>";
            })
            ->addColumn('author', function(Book $book){
                return "
                    <div class='d-flex align-items-center gap-2'>
                        <img src='" . asset($book->author->image) ."' width='40' height='40' class='rounded-5'>
                        <span>{$book->author->name}</span>
                    </div>
                ";
            })
            ->addColumn('reviews', function(Book $book){
                return $book->reviews()->count();
            })
            ->addColumn('category', function(Book $book){
                return $book->category->name;
            })
            ->editColumn('title', fn(Book $book) => $book->title)
            ->editColumn('source', function(Book $book){
                return "<a href='". asset('storage/' . $book->source) ."' target='_blank'>Link</a>";
            })
            ->editColumn('downloadable', function(Book $book){
                return $book->downloadable ? '<span class="text-success">downloadabled</span>' : '<span class="text-danger">not downloadable</span>';
            })
            ->rawColumns(['source', 'downloadable', 'author', 'action'])
            ->make(true);
        }
        return view('dashboard.books.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Session::forget('uploaded_files');
        return view('dashboard.books.create');
    }

    public function upload_images(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->file('file')) {
            $image = $request->file('file');

            $imagePath = 'temp/' . uniqid() . '.' . $image->getClientOriginalExtension();
    
            $manager = new ImageManager(new GdDriver());
            $optimizedImage = $manager->read($image)
                ->scale(width:250)
                ->encode(new AutoEncoder(quality: 75));
    
            Storage::disk('public')->put($imagePath, (string) $optimizedImage);

            return response()->json(['message' => 'Image uploaded successfully', 'path' => $imagePath]);
        }

        return response()->json(['message' => 'Image upload failed'], 400);
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request['downloadable'] = $request['downloadable'] == 'on' ? true : false;
        $request->validate([
            'title' => ['required', 'array'],
            'title.*' => ['required', 'min:2'],

            'description' => ['required', 'array'],
            'description.*' => ['required', 'min:2'],

            'downloadable' => ['boolean'],
            'keywords' => ['required'],
            'source' => ['required', 'mimes:pdf', 'max:20000'],
            'author_id' => ['required', Rule::exists('people', 'id')->where('type', PeopleType::Author->value)],
            'category_id' => ['required', 'exists:books_categories,id'],
        ]);

        $files = $request->images;

        if(count($files) == 0)
        {
            return response()->json(['errors' => ['invalid' => [__('custom-errors.books.create.min-one-image')]]], 422);
        }

        $path = "";
        if($request->source)
        {
            $path = 'pdf/' . uniqid() . '.' . $request->source->getClientOriginalExtension();
            $request->file('source')->storeAs('pdf', basename($path), 'public');
        }

        $book = Book::create([
            'title' => $request->title,
            'description' => $request->description,
            'downloadable' => $request->downloadable ?? 0,
            'source' => $path,
            'author_id' => $request->author_id,
            'keywords' => $request->keywords,
            'category_id' => $request->category_id,
        ]);

        foreach ($files as $filePath) {
            $new_path = str_replace('temp/', 'books/', $filePath);
            Storage::disk('public')->move($filePath, $new_path); // Move to final location
            BookImage::create([
                'url' => $new_path,
                'book_id' => $book->id
            ]);
        }

        return response()->json(['redirectUrl' => route('dashboard.books.edit', $book)]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $data_images = $book->images->map(fn($image) => [
            'id' => $image->id,
            'name' => basename($image->url),
            'size' => Storage::disk('public')->size($image->url),
            'url' => asset('storage/' . $image->url)
        ]);
        return view('dashboard.books.edit', compact('book', 'data_images'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $request['downloadable'] = $request['downloadable'] == 'on' ? true : false;
        $request->validate([
            'title' => ['required', 'array'],
            'title.*' => ['required', 'min:2'],

            'description' => ['required', 'array'],
            'description.*' => ['required', 'min:2'],

            'downloadable' => ['boolean'],
            'author_id' => ['required', Rule::exists('people', 'id')->where('type', PeopleType::Author->value)],
            'category_id' => ['required', 'exists:books_categories,id'],
            'keywords' => ['required'],
        ]);

        if($request->source)
        {
            $request->validate([
                'source' => ['required', 'mimes:pdf', 'max:20000'],
            ]);
        }

        $book->update([
            'title' => $request->title,
            'description' => $request->description,
            'downloadable' => $request->downloadable,
            'author_id' => $request->author_id,
            'category_id' => $request->category_id,
            'keywords' => $request->keywords,
        ]);

        if($request->source)
        {
            if(Storage::disk('public')->exists($book->source))
            {
                Storage::disk('public')->delete($book->source);
            }

            $path = 'pdf/' . uniqid() . '.' . $request->source->getClientOriginalExtension();
            $request->file('source')->storeAs('pdf', basename($path), 'public');
            
            $book->update([
                'source' => $path
            ]);
        }

        foreach($request->delete_images ?? [] as $image_id)
        {
            $image = $book->images()->findOrFail($image_id);

            if(Storage::disk('public')->exists($image->url))
            {
                Storage::disk('public')->delete($image->url);
            }

            $image->delete();
        }

        foreach ($request->upload_images ?? [] as $filePath) {
            $new_path = str_replace('temp/', 'books/', $filePath);
            Storage::disk('public')->move($filePath, $new_path); // Move to final location
            BookImage::create([
                'url' => $new_path,
                'book_id' => $book->id
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        if(Storage::disk('public')->exists($book->source))
        {
            Storage::disk('public')->delete($book->source);
        }

        $images = $book->images;

        foreach($images as $image)
        {
            if(Storage::disk('public')->exists($image->url))
            {
                Storage::disk('public')->delete($image->url);
            }
        }

        $book->delete();
    }
}
