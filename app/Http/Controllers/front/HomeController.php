<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Author;
use App\Models\Blog;
use App\Models\Book;
use App\Models\BooksCategory;
use App\Models\Contact;
use App\Models\Quote;
use App\Models\Seminar;
use App\PeopleType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $comming_events = Seminar::where('date', '>', now())->inRandomOrder()->first(['id', 'title', 'date']);

        if($comming_events)
        {
            $date = Carbon::parse($comming_events->date);
            $now = Carbon::now();
    
            $diffInDays = str_pad(floor(-$date->diffInDays($now)), 2, "0", STR_PAD_LEFT);
            $diffInHours = str_pad(floor(-$date->diffInHours($now) % 24), 2, "0", STR_PAD_LEFT);
            $diffInMinutes = str_pad(floor(-$date->diffInMinutes($now) % 60), 2, "0", STR_PAD_LEFT);
    
            $comming_events['remaining'] = (['days' => $diffInDays, 'hours' => $diffInHours, 'min' => $diffInMinutes]);
        }

        $books = Book::inRandomOrder()->take(10)->with('images', 'author')->get(['id', 'title', 'author_id']);
        $quotes = Quote::inRandomOrder()->take(10)->with('author')->get(['id', 'title', 'author_id']);

        $top_authors = $this->getTopAuthors();

        $articles = Article::with('category')->orderByDesc('created_at')->take(10)->get(['id', 'title', 'content', 'category_id', 'created_at', 'cover']);
        
        $blogs = Blog::with('users')->orderByDesc('created_at')->take(10)->get(['id', 'title', 'content', 'created_at', 'cover']);

        return view('front.home', compact('comming_events', 'books', 'quotes', 'top_authors', 'articles', 'blogs'));
    }

    private function getTopAuthors()
    {
        $top_authors = Author::where('type', PeopleType::Author->value)
        ->with('bookReviews')
        ->withCount([
            'bookReviews as book_review_avg_rating' => function ($query) {
                $query->select(\DB::raw('coalesce(avg(review_star), 0)'));
            }
        ])
        ->orderByDesc('book_review_avg_rating')
        ->take(2)
        ->get();

        return $top_authors;
    }

    public function about()
    {
        return view('front.about');
    }

    public function contact()
    {
        return view('front.contact');
    }
    
    public function add_contact(Request $request)
    {
        $request->validate([
            'message' => ['required', 'max:300']
        ]);

        $user_id = auth()->user()->id;

        Contact::create([
            'user_id' => $user_id,
            'message' => $request->message
        ]);
    }
}
