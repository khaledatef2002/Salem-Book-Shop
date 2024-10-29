<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{

    use HasFactory;

    protected $guarded = [];

    public function comments()
    {
        return $this->hasMany(BlogComment::class, 'blog_id');
    }

    public function likes()
    {
        return $this->hasMany(BlogLike::class, 'blog_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function authLikes()
    {
        return $this->hasMany(BlogLike::class)->where('user_id', auth()->user()->id);
    }
}
