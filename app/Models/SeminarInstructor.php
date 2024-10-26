<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeminarInstructor extends Model
{

    use HasFactory;
    protected $table = 'seminar_instructors';

    public function seminar()
    {
        return $this->belongsTo(Seminar::class, 'seminar_id');
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }
}
