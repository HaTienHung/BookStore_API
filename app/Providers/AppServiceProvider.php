<?php

namespace App\Providers;

use App\Models\Book;
use App\Policies\BookPolicy;
use App\Repositories\Book\BookInterface;
use App\Repositories\Book\BookRepository;
use App\Repositories\User\UserInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\Category\CategoryInterface;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Container\Container;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $repositories = [
            //             // OrderInterface::class => OrderRepository::class,
            UserInterface::class => UserRepository::class,
            //             // OrderItemInterface::class => OrderItemRepository::class,
            CategoryInterface::class => CategoryRepository::class,
            //             // InventoryInterface::class => InventoryRepository::class,
            //             // CartInterface::class => CartRepository::class,
            //             // DashboardInterface::class => DashboardRepository::class,
            BookInterface::class => BookRepository::class,
        ];

        foreach ($repositories as $interface => $repository) {
            $this->app->bind($interface, $repository);
        }

        // $this->app->bind(UserInterface::class, function () {
        //     return new UserRepository(new Container(), new Request(), new User());
        // });
        // $this->app->bind(BookInterface::class, function () {
        //     return new BookRepository(new Container(), new Request(), new Book());
        // });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Book::class, BookPolicy::class);
    }
}
