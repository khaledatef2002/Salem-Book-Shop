<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BooksCategory extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['name'];

    protected $guarded = [];

    public function books()
    {
        return $this->hasMany(Book::class, 'category_id');
    }
}
