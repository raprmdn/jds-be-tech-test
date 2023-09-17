<?php

namespace App\Repository\Eloquent;

use App\Models\NewsLog;
use App\Repository\NewsLogRepositoryInterface;

class NewsLogRepository implements NewsLogRepositoryInterface
{
    public function create(array $attributes): void
    {
        NewsLog::create([
            'news_id' => $attributes['news_id'],
            'user_id' => $attributes['user_id'],
            'ip' => $attributes['ip'],
            'action' => $attributes['action'],
            'message' => $attributes['message'],
            'data' => $attributes['data'],
        ]);
    }
}
