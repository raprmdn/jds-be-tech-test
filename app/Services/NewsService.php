<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Models\News;
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

    public function update(News $news, array $attributes): News
    {
        if (auth()->id() !== $news->user_id) {
            throw CustomException::unauthorized();
        }

        $attributes['excerpt'] = \Str::limit($attributes['content']);
        if (isset($attributes['thumbnail'])) {
            $attributes['thumbnail'] = $this->uploadImage('news', $attributes['thumbnail'], $news->slug);
        }

        return $this->newsRepository->update($news, $attributes);
    }
}
