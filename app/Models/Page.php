<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Page extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'content', 'slug'];

    // Automatically create a slug when the page is being saved
    public static function boot()
    {
        parent::boot();

        static::saving(function ($page) {
            $page->slug = Str::slug($page->title);
        });
    }
}
