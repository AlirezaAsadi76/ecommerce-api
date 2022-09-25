<?php

namespace App\Providers;

use App\Contracts\CartContract;
use App\Contracts\CategoryContracts;
use App\Contracts\OrderContracts;
use App\Contracts\ProductContracts;
use App\Contracts\TagContracts;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Tag;
use App\Repositories\CartRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\TagRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(TagContracts::class, function () {
            return new TagRepository(new Tag());
        });
        $this->app->bind(ProductContracts::class, function () {
            return new ProductRepository(new Product());
        });
        $this->app->bind(CategoryContracts::class, function () {
            return new CategoryRepository(new Category());
        });
        $this->app->bind(OrderContracts::class, function () {
            return new OrderRepository(new Order());
        });
        $this->app->bind(CartContract::class, function () {
            return new CartRepository(new Cart());
        });
    }
}
