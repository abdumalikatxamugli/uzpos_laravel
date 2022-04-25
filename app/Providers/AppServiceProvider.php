<?php

namespace App\Providers;

use App\Models\Point;
use App\Models\Product;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
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
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();

        View::composer('dashboard.transfer.edit', function ($view) {
            $points = Point::all();
            $products = Product::all();
            $view->with('points', $points)
                ->with('products', $products);
        });
        View::composer('dashboard.reports.goodsReport', function ($view) {
            $points = Point::all();
            $view->with('points', $points);
        });
    }
}
