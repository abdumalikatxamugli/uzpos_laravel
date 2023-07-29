<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Point;
use App\Models\Product;
use App\Models\User;
use App\PermissionManagement\Menu;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Matrix\Operators\Division;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();

        View::composer('*', function($view){
            $menu = new Menu();
            $view->with('menu', $menu);
        });

        View::composer('dashboard.transfer.edit', function ($view) {
            $points = Point::all();
            $products = Product::all();
            $view->with('points', $points)
                ->with('products', $products);
        });
        View::composer('dashboard.transfer.create', function ($view) {

            $toPoints = Point::where(function($query){
                $user = auth()->user();
                if($user->user_role != User::roles['ADMIN']){
                    $query->where('id', '<>', $user->point_id);
                }                
            })->get();
            $fromPoints = Point::where(function($query){
                $user = auth()->user();
                if($user->user_role != User::roles['ADMIN']){
                    $query->where('id', $user->point_id);
                }                
            })->get();
            $view->with('toPoints', $toPoints)->with('fromPoints', $fromPoints);
        });
        View::composer(['dashboard.party.edit', 'dashboard.party.create'], function ($view) {

            $points = Point::where(function($query){
                $user = auth()->user();
                if($user->user_role != User::roles['ADMIN']){
                    $query->where('id', $user->point_id);
                }                
            })->get();
            $view->with('points', $points);
        });
        
        View::composer(['dashboard.transfer.create', 'dashboard.transfer.create'], function ($view) {

            $points = Point::where(function($query){
                $user = auth()->user();
                if($user->user_role != User::roles['ADMIN']){
                    $query->where('id', '<>', $user->point_id);
                }                
            })->get();
            $view->with('toPoints', $points);
        });
        
        View::composer('dashboard.product.index', function ($view) {
            $all_products = Product::orderBy('name')->get();
            $categories = Category::orderBy('name')->get();
            $brands = Brand::orderBy('name')->get();
            $view->with('all_products', $all_products)->with('categories', $categories)->with('brands', $brands);
        });

        View::composer(['dashboard.order.edit_retail_order'], function($view){
            $products = Product::all()->keyBy('id');
            $payment_types =  Payment::PAYMENT_TYPES;
            $currencies = Payment::CURRENCIES;
            $points = Point::orderBy('name')->get();
            $view->with('products', $products)
                ->with('payment_types', $payment_types)
                ->with('currencies', $currencies)
                ->with('points', $points);
        });
        View::composer(['dashboard.expense.create'], function($view){
            $currencies = Payment::CURRENCIES;
            $view->with('currencies', $currencies);
        });
        View::composer(['dashboard.order.edit'], function($view){
            $products = Product::all()->keyBy('id');
            $payment_types =  Payment::PAYMENT_TYPES;
            $currencies = Payment::CURRENCIES;
            $points = Point::orderBy('name')->get();
            $view->with('products', $products)
                ->with('payment_types', $payment_types)
                ->with('currencies', $currencies)
                ->with('points', $points);
        });

        View::composer('*', function($view){
            if(auth()->user()){
                $is_admin = auth()->user()->user_role == User::roles['ADMIN'];
                $is_warehouse = auth()->user()->user_role == User::roles['WAREHOUSE_MANAGER'];
                $is_seller = auth()->user()->user_role == User::roles['SELLER'];
                $view->with('is_admin', $is_admin)->with('is_warehouse', $is_warehouse)->with('is_seller',$is_seller);
            }
        });
        
        View::composer(['dashboard.reports.runout', 'dashboard.reports.goods', 'dashboard.reports.goodsByDivision', 'dashboard.reports.salesByPoint'], function ($view) {
            $points = Point::where(function($query){
                $user = auth()->user();
                if($user->user_role != User::roles['ADMIN'] && $user->user_role != User::roles['WAREHOUSE_MANAGER']){
                    $query->where('id', $user->point_id);
                }                
            })->get();
            $categories = Category::orderBy('name')->get();
            $brands = Brand::orderBy('name')->get();
            $view->with('points', $points)->with('brands', $brands)->with('categories', $categories);
        });
        View::composer('dashboard.reports.esfByPeriod', function($view){
            $clients = Client::all();
            $view->with('clients', $clients);
        });
        
        View::composer(['dashboard.client.create', 'dashboard.client.edit', 'dashboard.clients.select'], function($view){
            $regions = Client::regionDict;
            $view->with('regions', $regions);
        });
        View::composer(['dashboard.client.index', 'dashboard.client.create', 'dashboard.client.edit'], function($view){
            $popup = request()->query('popup')?true:false;
            if($popup){
                $order = Order::where('id', request()->query('order_id'))->first();
                if(!$order){
                    abort(404);
                }
                $view->with('order', $order)->with('popup', $popup);
            }else{
                $view->with('popup', $popup);
            }
        });
        View::composer(['dashboard.reports.report1_1', 'dashboard.reports.report1_2', 'dashboard.reports.report1_3'], function($view){
            $user = auth()->user();
            if($user->role === 0)
            {
                $divisions = Point::all();
            }else
            {
                $divisions = [$user->division];
            }
            
            $products = Product::all();
            $categories = Category::all();
            $brands = Brand::all();
            $view->with('divisions', $divisions)
                ->with('products', $products)
                ->with('categories', $categories)
                ->with('brands', $brands);
        });
    }
}
