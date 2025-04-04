<?php

namespace App\Models;

use App\Models\Traits\HasTranslation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory, HasTranslation;


    protected $with = ["replies"];
    protected $withCount = ["upvotes", "downvotes"];
    protected $guarded = [];
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id')->orderByDesc('score');
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function news()
    {
        return $this->belongsTo(News::class, 'user_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'comment_votes', 'comment_id', 'user_id')->withPivot('vote_type')->withTimestamps();
    }

    public function upvotes()
    {
        return $this->belongsToMany(User::class, 'comment_votes', 'comment_id', 'user_id')->withPivot('vote_type')->withTimestamps()->where('vote_type', 1);
    }
    public function downvotes()
    {
        return $this->belongsToMany(User::class, 'comment_votes', 'comment_id', 'user_id')->withPivot('vote_type')->withTimestamps()->where('vote_type', 0);
    }
    public function commentsavedBy()
    {
        return $this->belongsToMany(User::class, 'comments_save', 'comment_id', 'user_id', 'id', 'id');
    }
    public function reportsavedBy()
    {
        return $this->belongsToMany(User::class, 'comments_report', 'comment_id', 'user_id', 'id', 'id');
    }
}
