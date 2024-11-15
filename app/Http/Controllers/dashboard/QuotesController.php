<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Quote;
use App\PeopleType;
use CodeZero\UniqueTranslation\UniqueTranslationRule;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class QuotesController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('can:quote_show', only: ['index']),
            new Middleware('can:quote_edit', only: ['edit', 'update']),
            new Middleware('can:quote_create', only: ['store', 'create']),
            new Middleware('can:quote_delete', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $quotes = Quote::with('author')->get();
            return DataTables::of($quotes)
            ->rawColumns(['action'])
            ->addColumn('action', function($row){
                return 
                "<div class='d-flex align-items-center justify-content-center gap-2'>"
                .
                ( Auth::user()->hasPermissionTo('quote_edit') ?
                "
                    <a href='" . route('dashboard.quote.edit', $row) . "'><i class='ri-settings-5-line fs-4' type='submit'></i></a>
                ":""
                )
                .
                ( Auth::user()->hasPermissionTo('quote_delete') ?
                "
                    <form id='remove_quote' data-id='".$row['id']."' onsubmit='remove_quote(event, this)'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button class='remove_button' onclick='remove_button(this)' type='button'><i class='ri-delete-bin-5-line text-danger fs-4'></i></button>
                    </form>
                ":""
                )
                .
                "</div>";
            })
            ->addColumn('author', function(Quote $quote){
                return "
                    <div class='d-flex align-items-center gap-2'>
                        <img src='" . asset($quote->author->image) ."' width='40' height='40' class='rounded-5'>
                        <span>{$quote->author->name}</span>
                    </div>
                ";
            })
            ->editColumn('title', function(Quote $quote){
                return $quote->title;
            })
            ->rawColumns(['author', 'action'])
            ->make(true);
        }
        return view('dashboard.quotes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.quotes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'array'],
            'title.*' => ['required', UniqueTranslationRule::for('quotes'), 'min:2'],
            'author_id' => ['required', Rule::exists('people', 'id')->where('type', PeopleType::Author->value)]
        ]);

        $quote = Quote::create($data);

        return response()->json(['redirectUrl' => route('dashboard.quote.edit', $quote)]);
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
    public function edit(Quote $quote)
    {
        return view('dashboard.quotes.edit', compact('quote'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quote $quote)
    {
        $data = $request->validate([
            'title' => ['required', 'array'],
            'title.*' => ['required', UniqueTranslationRule::for('quotes')->ignore($quote->id), 'min:2'],
            'author_id' => ['required', Rule::exists('people', 'id')->where('type', PeopleType::Author->value)]
        ]);

        $quote->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quote $quote)
    {
        $quote->delete();
    }
}
