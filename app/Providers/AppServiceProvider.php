<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Payment;
use App\Models\Point;
use App\Models\Product;
use App\Models\User;
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
        
        View::composer('dashboard.party.create', function ($view) {

            $points = Point::where(function($query){
                $user = auth()->user();
                if($user->user_role != User::roles['ADMIN']){
                    $query->where('id', $user->point_id);
                }                
            })->get();
            $view->with('points', $points);
        });
        View::composer('dashboard.party.edit', function ($view) {

            $points = Point::where(function($query){
                $user = auth()->user();
                if($user->user_role != User::roles['ADMIN']){
                    $query->where('id', $user->point_id);
                }                
            })->get();
            $view->with('points', $points);
        });
        View::composer('dashboard.transfer.create', function ($view) {

            $points = Point::where(function($query){
                $user = auth()->user();
                if($user->user_role != User::roles['ADMIN']){
                    $query->where('id', $user->point_id);
                }                
            })->get();
            $view->with('fromPoints', $points);
        });
        View::composer('dashboard.transfer.create', function ($view) {

            $points = Point::where(function($query){
                $user = auth()->user();
                if($user->user_role != User::roles['ADMIN']){
                    $query->where('id', '<>', $user->point_id);
                }                
            })->get();
            $view->with('toPoints', $points);
        });
        View::composer('dashboard.order.edit', function($view){
            $products = Product::all()->keyBy('id');
            $payment_types =  Payment::PAYMENT_TYPES;
            $currencies = Payment::CURRENCIES;
            $view->with('products', $products)
                ->with('payment_types', $payment_types)
                ->with('currencies', $currencies);
       });
       View::composer('dashboard.order.edit_retail_order', function($view){
            $products = Product::all()->keyBy('bar_code');
            $payment_types =  Payment::PAYMENT_TYPES;
            $currencies = Payment::CURRENCIES;
            $view->with('products', $products)
                ->with('payment_types', $payment_types)
                ->with('currencies', $currencies);
        });

        View::composer('dashboard.reports.goods', function ($view) {

            $points = Point::where(function($query){
                $user = auth()->user();
                if($user->user_role != User::roles['ADMIN']){
                    $query->where('id', $user->point_id);
                }                
            })->get();
            $categories = Category::orderBy('name')->get();
            $brands = Brand::orderBy('name')->get();
            $view->with('points', $points)->with('brands', $brands)->with('categories', $categories);
        });
        
        View::composer('dashboard.reports.runout', function ($view) {

            $points = Point::where(function($query){
                $user = auth()->user();
                if($user->user_role != User::roles['ADMIN']){
                    $query->where('id', $user->point_id);
                }                
            })->get();
            $categories = Category::orderBy('name')->get();
            $brands = Brand::orderBy('name')->get();
            $view->with('points', $points)->with('brands', $brands)->with('categories', $categories);
        });

        View::composer('dashboard.reports.goodsByDivision', function ($view) {

            $points = Point::where(function($query){
                $user = auth()->user();
                if($user->user_role != User::roles['ADMIN']){
                    $query->where('id', $user->point_id);
                }                
            })->get();
            $categories = Category::orderBy('name')->get();
            $brands = Brand::orderBy('name')->get();
            $view->with('points', $points)->with('brands', $brands)->with('categories', $categories);
        });
       
    }
}
