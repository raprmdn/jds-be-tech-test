<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [
        'user_id',
        'news_id',
        'parent_id',
        'comment'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function news(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(News::class, 'news_id');
    }
}
