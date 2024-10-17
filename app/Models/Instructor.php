<?php

namespace App\Models;

use App\PeopleType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Person
{

    use HasFactory;

    protected $table = 'people';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model){
            $model->type = PeopleType::Instructor->value;
        });
    }
    
    public function seminars()
    {
        return $this->belongsToMany(Seminar::class, 'SeminarInstructors', 'instructor_id', 'seminar_id');
    }
}
