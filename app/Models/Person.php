<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Person extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['name', 'about'];

    protected $guarded = [];

    public function quotes()
    {
        return $this->hasMany(Quote::class, 'author_id');
    }
}
