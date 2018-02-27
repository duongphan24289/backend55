<?php

namespace App\Providers;

use App\Repositories\ImageRepository;
use App\Repositories\ImageRepositoryImagick;
use App\Repositories\TodoRepository;
use App\Repositories\TodoRepositoryEloquent;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     */
    public function register()
    {

        $this->app->bind(UserRepository::class, UserRepositoryEloquent::class);
        $this->app->bind(TodoRepository::class, TodoRepositoryEloquent::class);
        $this->app->bind(ImageRepository::class, ImageRepositoryImagick::class);
        //:end-bindings:
    }
}
