<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{

    use HasFactory;

    public function comments()
    {
        return $this->hasMany(BlogComment::class, 'blog_id');
    }

    public function likes()
    {
        return $this->hasMany(BlogLike::class, 'blog_id');
    }
}
