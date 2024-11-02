<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Quote extends Model
{

    use HasFactory;

    protected $guarded = [];

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
        return $this->hasMany(QuoteLike::class)->where('user_id', Auth::user()->id);
    }

}
