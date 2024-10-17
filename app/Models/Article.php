<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    use HasFactory;

    public function category()
    {
        return $this->belongsTo(ArticleCategory::class, 'category_id');
    }

    public function comments()
    {
        return $this->hasMany(ArticleComment::class, 'article_id');
    }

    public function likes()
    {
        return $this->hasMany(ArticleLike::class, 'article_id');
    }
}
