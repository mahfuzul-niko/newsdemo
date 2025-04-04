<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

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


     public function getAvatar()
     {
         if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
             return $this->avatar; // Return if avatar is a URL
         }
     
         return Storage::url($this->avatar); // Wrap in Storage::url if not a URL
     }
     
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getLocale()
    {
        return $this->locale;
    }
    public function getLocation()
    {
        return [
            'country' => $this->country,
            'state' => $this->state,
            'city' => $this->city,
            'zip' => $this->zip,
            'address' => $this->address,
        ];
    }
    public function getInterests()
    {
        return  $this->categories->pluck('id')->toArray();
    }
    public function savedNews()
    {

        return $this->belongsToMany(News::class, 'save_news', 'user_id', 'news_id', 'id', 'id');
    }

    public function votes()
    {
        return $this->belongsToMany(Comment::class, 'comment_votes', 'user_id', 'comment_id', 'id', 'id');
    }
    public function upvotes()
    {
        return $this->belongsToMany(Comment::class, 'comment_votes', 'user_id', 'comment_id', 'id', 'id')->where('vote_type', 1);
    }
    public function downvotes()
    {
        return $this->belongsToMany(Comment::class, 'comment_votes', 'user_id', 'comment_id', 'id', 'id')->where('vote_type', 0);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function commentsaves()
    {
        return $this->belongsToMany(Comment::class, 'comments_save', 'user_id', 'comment_id', 'id', 'id');
    }
    public function reportsaves()
    {
        return $this->belongsToMany(Comment::class, 'comments_report', 'user_id', 'comment_id', 'id', 'id');
    }
}
