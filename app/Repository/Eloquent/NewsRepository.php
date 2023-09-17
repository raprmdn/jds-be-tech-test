<?php

namespace App\Repository\Eloquent;

use App\Models\Image;
use App\Models\News;
use App\Repository\NewsRepositoryInterface;

class NewsRepository implements NewsRepositoryInterface
{

    public function index()
    {
        return News::query()
            ->with(['thumbnail', 'user'])
            ->latest()
            ->paginate(10);
    }

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
        return News::where('slug', $slug)->withTrashed()->exists();
    }

    public function update(News $news, array $attributes): News
    {
        $news->update([
            'title' => $attributes['title'],
            'excerpt' => $attributes['excerpt'],
            'content' => $attributes['content'],
        ]);

        if (isset($attributes['thumbnail'])) {
            if ($news->thumbnail) {
                \Storage::delete($news->thumbnail->url);
                $news->thumbnail()?->delete();
            }

            $thumbnail = new Image();
            $thumbnail->url = $attributes['thumbnail'];
            $news->thumbnail()->save($thumbnail);
        }

        return $news->load('thumbnail');
    }

    public function show(News $news): News
    {
        return $news->load([
            'thumbnail',
            'user',
            'comments' => function ($query) {
                $query->orderBy('created_at', 'desc')->isParent()->with([
                    'user',
                    'replies' => fn ($query)  => $query->with('user')
                ]);
            },
        ]);
    }

    public function delete(News $news): void
    {
        $news->delete();
    }

}
