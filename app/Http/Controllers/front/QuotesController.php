<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Models\QuoteLike;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class QuotesController extends Controller implements HasMiddleware
{

    private const page_limit = 13;

    public static function middleware()
    {
        return [
            new Middleware('auth', only: ['likeAction'])
        ];
    }

    public function index()
    {
        $quotes = Quote::withCount('likes');
        if(auth()->check())
        {
            $quotes = $quotes->with(['authLikes' => function ($query) {
                            $query->select('id', 'quote_id')->where('user_id', auth()->user()->id);
                        }]);
        }
        $quotes = $quotes->paginate(13);
        return view('front.quotes.view-all', compact('quotes'));
    }


    public function getAllQuotesAjax(Request $request)
    {
        $limit = $request->query('limit', self::page_limit);
        $search = $request->query('search', '');
        
        $quotes = Quote::withCount('likes');
        if(auth()->check())
        {
            $quotes= $quotes->with(['authLikes' => function ($query) {
                $query->select('id', 'quote_id')->where('user_id', auth()->user()->id);
            }]);
        }
        if($search)
        {
            $quotes->whereHas('author', function($q) use ($search){
                $q->where('name', 'like', "%$search%");
            });
        }

        switch($request->query('sort'))
        {
            case 'publish-old':
                $quotes->orderBy('created_at');
                break;
            case 'name-a':
                $quotes->orderBy('title');
                break;
            case 'name-z':
                $quotes->orderByDesc('title');
                break;
            case 'likes-highest':
                $quotes->orderByDesc('likes_count');
                break;
            case 'likes-highest':
                $quotes->orderBy('likes_count');
                break;
            default:
                $quotes->orderByDesc('created_at');
        }

        $quotes = $quotes->paginate($limit);

        return view('front.parts.quotes-list', compact('quotes'));
    }

    public function likeAction(Request $request)
    {
        $request->validate([
            'id' => 'exists:quotes'
        ]);

        $like = QuoteLike::where('quote_id', $request->id)->where('user_id', auth()->user()->id);

        $state = 'Liked';

        if($like->count() > 0)
        {
            $like->delete();
            $state = 'Like';
        }
        else
        {
            QuoteLike::create([
                'quote_id' => $request->id,
                'user_id' => auth()->user()->id
            ]);
        }
        $likes = QuoteLike::where('quote_id', $request->id)->count();

        return json_encode(['state' => $state, 'likes_count' => $likes]);
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
    public function show(string $id)
    {
        //
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
