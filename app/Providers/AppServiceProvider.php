<?php

namespace App\Providers;

use App\Repositories\Book\BookInterface;
use App\Repositories\Book\BookRepository;
use App\Repositories\User\UserInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\Category\CategoryInterface;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $repositories = [
            // OrderInterface::class => OrderRepository::class,
            UserInterface::class => UserRepository::class,
            // ProductInterface::class => ProductRepository::class,
            // OrderItemInterface::class => OrderItemRepository::class,
            CategoryInterface::class => CategoryRepository::class,
            // InventoryInterface::class => InventoryRepository::class,
            // CartInterface::class => CartRepository::class,
            // DashboardInterface::class => DashboardRepository::class,
            BookInterface::class => BookRepository::class,
        ];

        foreach ($repositories as $interface => $repository) {
            $this->app->bind($interface, $repository);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
