<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{

    use HasFactory;

    protected $casts = [
        'date' => 'datetime', // or 'date' if you only need the date portion
    ];

    public function instructors()
    {
        return $this->belongsToMany(Instructor::class, 'seminar_instructors', 'seminar_id', 'instructor_id');
    }

    public function attendants()
    {
        return $this->belongsToMany(User::class, 'attendants', 'seminar_id', 'user_id');
    }

    public function authAttendants()
    {
        return $this->belongsToMany(User::class, 'attendants', 'seminar_id', 'user_id')
                    ->where('user_id', auth()->id());
    }

    public function media()
    {
        return $this->hasMany(SeminarMedia::class, 'seminar_id');
    }

    public function reviews()
    {
        return $this->hasMany(SeminarReview::class, 'seminar_id');
    }

    public function authReview()
    {
        return $this->hasMany(SeminarReview::class)->where('user_id', auth()->user()->id);
    }

    public function getAvgReviewAttribute()
    {
        $total_reviews = $this->reviews->count();
        $sum_of_reviews = 0;
        foreach($this->reviews as $review)
        {
            $sum_of_reviews += $review->review_star;
        }

        return ($total_reviews > 0) ? $sum_of_reviews / $total_reviews : 0;
    }
}
