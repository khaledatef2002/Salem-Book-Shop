<?php

namespace App\helper;

use App\Models\ArticleCategory;
use App\Models\Author;
use App\Models\BooksCategory;
use App\PeopleType;
use Illuminate\Http\Request;

class select2
{
    /**
     * Create a new class instance.
     */
    public function authors(Request $request)
    {
        $search = $request->get('q'); // For searching functionality

        $authors = Author::where('type', PeopleType::Author->value)->when($search, function($query) use ($search) {
                return $query->where('name', 'LIKE', "%{$search}%");
            })
            ->get();

        return response()->json($authors);
    }

    public function book_category(Request $request)
    {
        $search = $request->get('q'); // For searching functionality

        $categories = BooksCategory::where('name', 'LIKE', "%{$search}%")
        ->get();

        return response()->json($categories);
    }

    public function article_category(Request $request)
    {
        $search = $request->get('q'); // For searching functionality

        $categories = ArticleCategory::where('name', 'LIKE', "%{$search}%")
        ->get();

        return response()->json($categories);
    }

    public function instructors(Request $request)
    {
        $search = $request->get('q'); // For searching functionality

        $instructors = Author::where('type', PeopleType::Instructor->value)->when($search, function($query) use ($search) {
                return $query->where('name', 'LIKE', "%{$search}%");
            })
            ->get();

        return response()->json($instructors);
    }
}
