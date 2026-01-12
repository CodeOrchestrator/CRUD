<?php

namespace App\Providers;

use App\Repositories\FactoriesRepository;
use App\Repositories\Interface\FactoriesRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
          FactoriesRepositoryInterface::class,
          FactoriesRepository::class
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
