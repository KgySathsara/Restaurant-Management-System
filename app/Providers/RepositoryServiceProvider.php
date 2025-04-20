<?php

namespace App\Providers;

use App\Repositories\Eloquent\ConcessionRepository;
use App\Repositories\Eloquent\OrderRepository;
use App\Repositories\Interfaces\ConcessionRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ConcessionRepositoryInterface::class,
            ConcessionRepository::class
        );

        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}
