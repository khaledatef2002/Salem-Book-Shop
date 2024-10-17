<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeminarReview extends Model
{

    use HasFactory;

    public function seminar()
    {
        return $this->belongsTo(Seminar::class, 'seminar_id');
    }

    public function review()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
