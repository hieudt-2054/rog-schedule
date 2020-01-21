<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\DatabaseManager;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $db = $this->app->make(DatabaseManager::class);

        $this->app->singleton(
            \App\Repositories\Contracts\UserRepositoryInterface::class,
            \App\Repositories\Eloquents\UserRepository::class
        );
    }
}
