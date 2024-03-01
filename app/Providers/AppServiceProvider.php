<?php

namespace App\Providers;

use App\Service\SessionCartService;
use Illuminate\Support\ServiceProvider;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepositoryInterface;
use App\Repository\ProductRepository;
use App\Repository\UserRepositoryInterface;
use App\Repository\UserRepository;
use App\Repository\CartRepositoryInterface;
use App\Repository\CartRepository;
use App\Service\CartServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);

        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);

        $this->app->bind(CartServiceInterface::class, SessionCartService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
