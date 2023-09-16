<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repository\UserRepositoryInterface::class,
            \App\Repository\Eloquent\UserRepository::class
        );

        $this->app->bind(
            \App\Repository\NewsRepositoryInterface::class,
            \App\Repository\Eloquent\NewsRepository::class
        );

        $this->app->bind(
            \App\Repository\CommentRepositoryInterface::class,
            \App\Repository\Eloquent\CommentRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
