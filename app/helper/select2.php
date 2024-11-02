<?php

namespace App\helper;

use App\Models\Author;
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
}
