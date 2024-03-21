<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use HasFactory;
    protected $fillable = [
        'imageable_type',
        'imageable_id',
        'path',
        'name',
        'extension',
        'description',
    ];

    protected $appends = [
        'url_temp'
    ];
    public function UrlTemp(): Attribute
    {
        return new Attribute(
            get: fn() => asset('storage/' .$this->path)
        );;
    }

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
