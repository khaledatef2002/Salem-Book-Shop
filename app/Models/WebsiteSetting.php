<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class WebsiteSetting extends Model
{

    use HasFactory, HasTranslations;

    protected $translatable = ['site_title', 'description'];

    protected $guarded = [];
}
