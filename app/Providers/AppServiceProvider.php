<?php

namespace App\Providers;

use App\Repositories\CategoryRepository;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\OrderItemsRepository;
use App\Repositories\OrderItemsRepositoryInterface;
use App\Repositories\OrdersRepository;
use App\Repositories\OrdersRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Services\CategoryService;
use App\Services\OrderItemsService;
use App\Services\OrdersService;
use App\Services\ProductService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //user
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserService::class, function ($app) {
            return new UserService($app->make(UserRepositoryInterface::class));
        });


        //category
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(CategoryService::class, function ($app) {
            return new CategoryService($app->make(CategoryRepositoryInterface::class));
        });

        //product
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductService::class, function ($app) {
            return new ProductService($app->make(ProductRepositoryInterface::class));
        });

        //order
        $this->app->bind(OrdersRepositoryInterface::class, OrdersRepository::class);
        $this->app->bind(OrdersService::class, function ($app) {
            return new OrdersService($app->make(OrdersRepositoryInterface::class));
        });

        //order-items
        $this->app->bind(OrderItemsRepositoryInterface::class, OrderItemsRepository::class);
        $this->app->bind(OrderItemsService::class, function ($app) {
            return new OrderItemsService($app->make(OrderItemsRepositoryInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
