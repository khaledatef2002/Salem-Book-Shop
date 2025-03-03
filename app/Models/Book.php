<?php

namespace App\Models;

use App\BookRequestsStatesType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Translatable\HasTranslations;

class Book extends Model
{

    use HasFactory, HasTranslations;

    public $translatable = ['title', 'description'];

    protected $guarded = [];

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

    public function getAvgReviewAttribute()
    {
        $total_reviews = $this->reviews->count();
        $sum_of_reviews = 0;
        foreach($this->reviews as $review)
        {
            $sum_of_reviews += $review->review_star;
        }

        $avg = number_format(($total_reviews > 0) ? $sum_of_reviews / $total_reviews : 0, 2);
        return $avg;
    }

    public function authReview()
    {
        return $this->hasMany(BookReview::class)->where('user_id', Auth::user()->id);
    }

    public function authUnlocked()
    {
        return Auth::check() && $this->hasMany(BookRequest::class)->where('user_id', Auth::user()->id)->where('state', BookRequestsStatesType::approved->value)->count() > 0;
    }

    public function authPendingRequest()
    {
        return Auth::check() && $this->hasMany(BookRequest::class)->where('user_id', Auth::user()->id)->where('state', BookRequestsStatesType::pending->value)->count() > 0;
    }
}
