<?php

namespace App\Providers;

use App\Domain\SportsCar\SportsCarRepository;
use App\Infrastructure\Persistence\Eloquent\SportsCar\EloquentSportsCarRepository;
use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\Eloquent\User\EloquentUserRepository;
use App\Domain\Order\OrderRepository;
use App\Infrastructure\Persistence\Eloquent\Order\EloquentOrderRepository;
use Illuminate\Support\ServiceProvider;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SportsCarRepository::class, EloquentSportsCarRepository::class);
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        $this->app->bind(OrderRepository::class, EloquentOrderRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
