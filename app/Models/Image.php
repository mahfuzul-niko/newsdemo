<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['url'];

    public function news()
    {
        return $this->belongsTo(News::class);
    }
    protected static function booted(): void
    {

        if (Request::segment(1) !=  'admin') {
            static::addGlobalScope('active', function (Builder $builder) {
                $builder->whereHas('news', function ($query) {
                    $query->where('image_status', 1);
                });
            });
        }
    }
}
