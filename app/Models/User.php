<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\BookRequestsStatesType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
        'image',
        'country_code',
        'is_admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $appends = ['full_name', 'display_image'];

    public function seminars()
    {
        return $this->belongsToMany(Seminar::class, 'attendants', 'user_id', 'seminar_id');
    }

    public function seminar_reviews()
    {
        return $this->hasMany(SeminarReview::class, 'user_id');
    }

    public function quote_likes()
    {
        return $this->hasMany(QuoteLike::class, 'user_id');
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'user_id');
    }

    public function book_reviews()
    {
        return $this->hasMany(BookReview::class, 'user_id');
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'article_id');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function getDisplayImageAttribute()
    {
        return asset($this->image ? 'storage/' . $this->image : 'front/imgs/user-dummy-img.jpg');
    }

    public function unlocked_books()
    {
        return $this->belongsToMany(Book::class, 'book_requests', 'user_id', 'book_id')
        ->wherePivot('state', BookRequestsStatesType::approved->value);
    }
}
