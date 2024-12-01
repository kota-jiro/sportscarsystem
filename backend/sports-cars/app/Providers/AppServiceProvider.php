<?php

namespace App\Providers;

use App\Domain\SportsCar\SportsCarRepository;
use App\Infrastructure\Persistence\Eloquent\SportsCar\EloquentSportsCarRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SportsCarRepository::class, EloquentSportsCarRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
