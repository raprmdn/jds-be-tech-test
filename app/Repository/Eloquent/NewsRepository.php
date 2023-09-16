<?php

namespace App\Repository\Eloquent;

use App\Models\Image;
use App\Models\News;
use App\Repository\NewsRepositoryInterface;

class NewsRepository implements NewsRepositoryInterface
{

    public function create(array $attributes)
    {
        $news = News::create([
            'title' => $attributes['title'],
            'slug' => $attributes['slug'],
            'excerpt' => $attributes['excerpt'],
            'content' => $attributes['content'],
            'user_id' => $attributes['user_id'],
        ]);

        $thumbnail = new Image();
        $thumbnail->url = $attributes['thumbnail'];
        $news->thumbnail()->save($thumbnail);

        return $news->load('thumbnail');
    }

    public function slugExists(string $slug): bool
    {
        return News::where('slug', $slug)->exists();
    }

}
