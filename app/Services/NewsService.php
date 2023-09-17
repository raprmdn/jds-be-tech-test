<?php

namespace App\Services;

use App\Events\NewsCreatedEvent;
use App\Events\NewsDeletedEvent;
use App\Events\NewsUpdatedEvent;
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

    public function index()
    {
        return $this->newsRepository->index();
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

        $news = $this->newsRepository->create($attributes);

        event(new NewsCreatedEvent($news, auth()->user(), request()->ip()));

        return $news;
    }

    /**
     * @throws CustomException
     */
    public function update(News $news, array $attributes): News
    {
        $this->authorize($news);

        $attributes['excerpt'] = \Str::limit($attributes['content']);
        if (isset($attributes['thumbnail'])) {
            $attributes['thumbnail'] = $this->uploadImage('news', $attributes['thumbnail'], $news->slug);
        }

        $news = $this->newsRepository->update($news, $attributes);

        event(new NewsUpdatedEvent($news, auth()->user(), request()->ip()));

        return $news;
    }

    public function show(News $news)
    {
        return $this->newsRepository->show($news);
    }

    /**
     * @throws CustomException
     */
    public function delete(News $news): void
    {
        $this->authorize($news);

        event(new NewsDeletedEvent($news, auth()->user(), request()->ip()));

        $this->newsRepository->delete($news);
    }

    /**
     * @throws CustomException
     */
    private function authorize(News $news): void
    {
        if (auth()->id() !== $news->user_id) {
            throw CustomException::unauthorized();
        }
    }
}
