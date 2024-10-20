<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{

    use HasFactory;

    public function likes()
    {
        return $this->hasMany(QuoteLike::class, 'quote_id');
    }
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
    public function authLikes()
    {
        return $this->hasMany(QuoteLike::class)->where('user_id', auth()->user()->id);
    }

}
