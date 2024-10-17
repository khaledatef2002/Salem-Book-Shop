<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    use HasFactory;

    public function category()
    {
        return $this->belongsTo(BooksCategory::class, 'category_id');
    }

    public function reviews()
    {
        return $this->hasMany(BookReview::class, 'book_id');
    }

    public function images()
    {
        return $this->hasMany(BookImage::class, 'book_id');
    }

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }
}
