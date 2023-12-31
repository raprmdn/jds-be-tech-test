<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'url',
        'imageable_id',
        'imageable_type',
    ];

    public function imageable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    protected function fullUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => asset('/storage/' . $attributes['url']),
        );
    }
}
