<?php

namespace App\Providers;

use App\Repositories\FactoriesRepository;
use App\Repositories\Interface\FactoriesRepositoryInterface;
use App\Repositories\Interface\ProductsRepositoryInterface;
use App\Repositories\ProductsRepository;
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
        $this->app->bind(
            ProductsRepositoryInterface::class,
            ProductsRepository::class
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
