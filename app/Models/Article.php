<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Translatable\HasTranslations;

class Article extends Model
{

    use HasFactory, HasTranslations;

    public $translatable = ['title', 'content'];

    protected $guarded = [];

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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function authLikes()
    {
        return $this->hasMany(ArticleLike::class)->where('user_id', Auth::user()->id);
    }
    public function images()
    {
        return $this->hasMany(ArticleImage::class);
    }
}
