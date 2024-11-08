<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ArticleCategory extends Model
{

    use HasFactory, HasTranslations;

    public $translatable = ['name'];

    protected $guarded = [];

    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id');
    }
}
