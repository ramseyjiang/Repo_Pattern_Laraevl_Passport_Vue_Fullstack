<?php

namespace Rspafs\Providers;

use Illuminate\Support\ServiceProvider;
use Rspafs\Contracts\Repositories\BlogRepositoryContract;
use Rspafs\Contracts\Repositories\LogRepositoryContract;
use Rspafs\Contracts\Repositories\UserRepositoryContract;
use Rspafs\Contracts\Services\UserServiceContract;
use Rspafs\Repositories\BlogRepository;
use Rspafs\Repositories\LogRepository;
use Rspafs\Repositories\UserRepository;
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
