<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeminarReview extends Model
{

    use HasFactory;

    protected $guarded = [];

    public function seminar()
    {
        return $this->belongsTo(Seminar::class, 'seminar_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
