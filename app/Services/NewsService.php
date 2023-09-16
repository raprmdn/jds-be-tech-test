<?php

namespace App\Services;

use App\Repository\NewsRepositoryInterface;
use App\Traits\ImageTrait;

class NewsService
{
    use ImageTrait;

    private NewsRepositoryInterface $newsRepository;

    public function __construct(NewsRepositoryInterface $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    public function create(array $attributes)
    {
        $attributes['slug'] = $attributes['slug'] ?? \Str::slug($attributes['title']);

        $hasNews = $this->newsRepository->slugExists($attributes['slug']);
        if ($hasNews) {
            $attributes['slug'] = $attributes['slug'] . '-' . time();
        }

        $attributes['excerpt'] = \Str::limit($attributes['content']);
        $attributes['user_id'] = auth()->id();
        $attributes['thumbnail'] = $this->uploadImage('news', $attributes['thumbnail'], $attributes['slug']);

        return $this->newsRepository->create($attributes);
    }
}
