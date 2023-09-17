<?php

namespace App\Listeners;

use App\Events\NewsCreatedEvent;
use App\Events\NewsDeletedEvent;
use App\Events\NewsUpdatedEvent;
use App\Models\NewsLog;
use App\Repository\NewsLogRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewsEventListener
{
    private NewsLogRepositoryInterface $newsLogRepository;
    /**
     * Create the event listener.
     */
    public function __construct(NewsLogRepositoryInterface $newsLogRepository)
    {
        $this->newsLogRepository = $newsLogRepository;
    }

    /**
     * Handle the event.
     */
    public function handle(NewsCreatedEvent|NewsUpdatedEvent|NewsDeletedEvent $event): void
    {
        $news = $event->news;
        $user = $event->user;
        $ip = $event->ip;
        $action = get_class($event);
        $message = "News: {$action}, ID: {$news->id}, Title: {$news->title}, User: {$user->name} - {$user->email}, IP: {$ip}";

        info($message);

        $this->newsLogRepository->create([
            'news_id' => $news->id,
            'user_id' => $user->id,
            'ip' => $ip,
            'action' => $action,
            'message' => $message,
            'data' => json_encode($news),
        ]);
    }
}
