<?php

namespace App\Models;

use App\Helpers\System;
use App\Models\Traits\HasTranslation;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory, HasTranslation;
    protected $guarded = [];

    protected $casts = ['processed_timestamp' => 'timestamp'];


    public function source(): Attribute
    {
        return Attribute::make(get: fn() => $this->attributes['soruce']);
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderByDesc('score');
    }

    public function savedBy()
    {
        return $this->belongsToMany(User::class, 'save_news', 'news_id', 'user_id', 'id', 'id');
    }

    public function getRouteKey()
    {
        return Str::slug($this->title) . '-' . $this->id;
    }

    public function resolveRouteBinding($value, $field = null)
    {
        $id = last(explode('-', $value));
        $model = parent::resolveRouteBinding($id, $field);
        if (!$model) abort(404);
        if ($model->getRouteKey() == $value) {
            return $model;
        }
        throw new HttpResponseException(redirect()->to(route(request()->route()->getName(), $model)));
    }

    public function scopeInterested($query)
    {
        return $query->whereHas('category', fn($query) => $query->whereIn('id', System::getInterests()));
    }

    public function reads()
    {
        return $this->hasMany(Read::class);
    }

    public function keywords()
{
    return $this->belongsToMany(Keyword::class, 'keyword_news'); // Assuming 'keyword_news' is the pivot table
}


    protected static function booted(): void
    {
        if (Request::segment(1) !=  'admin') {
            static::addGlobalScope('active', function (Builder $builder) {
                $builder->where('status', 1);
            });
        }
    }
}
