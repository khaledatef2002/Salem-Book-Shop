<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{

    use HasFactory;

    public function instructors()
    {
        return $this->belongsToMany(Instructor::class, 'SeminarInstructors', 'seminar_id', 'instructor_id');
    }

    public function attendants()
    {
        return $this->belongsToMany(User::class, 'attendants', 'seminar_id', 'user_id');
    }

    public function media()
    {
        return $this->hasMany(SeminarMedia::class, 'seminar_id');
    }

    public function reviews()
    {
        return $this->hasMany(SeminarReview::class, 'seminar_id');
    }
}
