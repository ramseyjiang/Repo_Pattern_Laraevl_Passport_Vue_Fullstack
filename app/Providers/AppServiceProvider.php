<?php

namespace Rspafs\Providers;

use Illuminate\Support\ServiceProvider;
use Rspafs\Contracts\Repositories\BlogRepositoryContract;
use Rspafs\Contracts\Repositories\LogRepositoryContract;
use Rspafs\Contracts\Repositories\TaskRepositoryContract;
use Rspafs\Contracts\Repositories\UserRepositoryContract;
use Rspafs\Contracts\Services\TaskServiceContract;
use Rspafs\Contracts\Services\UserServiceContract;
use Rspafs\Repositories\BlogRepository;
use Rspafs\Repositories\LogRepository;
use Rspafs\Repositories\TaskRepository;
use Rspafs\Repositories\UserRepository;
use Rspafs\Services\TaskService;
use Rspafs\Services\UserService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(UserServiceContract::class, UserService::class);
        $this->app->bind(LogRepositoryContract::class, LogRepository::class);
        $this->app->bind(BlogRepositoryContract::class, BlogRepository::class);
        $this->app->bind(TaskRepositoryContract::class, TaskRepository::class);
        $this->app->bind(TaskServiceContract::class, TaskService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
