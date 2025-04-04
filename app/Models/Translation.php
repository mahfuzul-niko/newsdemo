<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Translation extends Model
{
    use HasFactory;
    protected $fillable = ['locale', 'column', 'value'];
    public function translateable(): MorphTo
    {
        return $this->morphTo();
    }
}
