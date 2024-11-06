<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function quotes()
    {
        return $this->hasMany(Quote::class, 'author_id');
    }
}
