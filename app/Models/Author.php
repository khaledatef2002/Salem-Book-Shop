<?php

namespace App\Models;

use App\PeopleType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Person
{

    use HasFactory;

    protected $table = 'people';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model){
            $model->type = PeopleType::Author->value;
        });
    }

    public function books()
    {
        return $this->hasMany(Book::class, 'author_id');
    }
}
