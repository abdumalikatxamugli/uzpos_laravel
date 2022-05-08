<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Dashboard\BrandResourceController;
use App\Http\Controllers\Dashboard\CategoryResourceController;
use App\Http\Controllers\Dashboard\ClientResourceController;
use App\Http\Controllers\Dashboard\ItemResourceController;
use App\Http\Controllers\Dashboard\MetricResourceControlller;
use App\Http\Controllers\Dashboard\PartyResourceController;
use App\Http\Controllers\Dashboard\PointResourceController;
use App\Http\Controllers\Dashboard\ProductResourceController;
use App\Http\Controllers\Dashboard\ReportContoller;
use App\Http\Controllers\Dashboard\TransferItemResourceController;
use App\Http\Controllers\Dashboard\TransferResourceController;
use App\Http\Controllers\Dashboard\UserResourceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::view("/", "login")->name("dashboard.login");
Route::post("/", [AuthController::class, 'dashboardLogin'])->name("dashboard.login");

Route::group(['middleware'=>['auth'], 'prefix'=>'dashboard'], function(){
    Route::get("main", [DashboardController::class, 'main'])->name('dashboard.main');
    Route::resource('metric', MetricResourceControlller::class, ['as'=>'dashboard']);
    Route::resource('point', PointResourceController::class, ['as'=>'dashboard']);
    Route::resource('client', ClientResourceController::class, ['as'=>'dashboard']);
    Route::resource('product', ProductResourceController::class, ['as'=>'dashboard']);
    Route::resource('user', UserResourceController::class, ['as'=>'dashboard']);
    Route::resource('category', CategoryResourceController::class, ['as'=>'dashboard']);
    Route::resource('brand', BrandResourceController::class, ['as'=>'dashboard']);
    Route::resource('party', PartyResourceController::class, ['as'=>'dashboard']);
    Route::resource('item', ItemResourceController::class, ['as'=>'dashboard']);
    Route::resource('transfer', TransferResourceController::class, ['as'=>'dashboard']);
    Route::get('transfer/finish/{transfer}', [TransferResourceController::class, 'finish'])->name('dashboard.transfer.finish');
    Route::resource('transferItem', TransferItemResourceController::class, ['as'=>'dashboard']);
    // Route::get("orders", OrderListController::class, ['as'=>'dashboard']);
    Route::get("goodsReport", [ReportContoller::class, 'goodsReport'])->name('dashboard.goodsReport');
    Route::get('logout', [AuthController::class, 'logout'])->name('dashboard.logout');


    //order routes
    Route::get('neworder', [OrderController::class, 'new'])->name('dashboard.order.new');
    Route::resource('orders', OrderController::class, ['as'=>'dashboard']);  
    Route::get('client/select/{order}', [ClientController::class, 'select'])->name('dashboard.order.client.select'); 
    Route::get('client/append/{order}/{client}', [ClientController::class, 'appendToOrder'])->name('dashboard.client.appendToOrder');
    Route::post('client/append/{order}', [ClientController::class, 'createAndAppendtoOrder'])->name('dashboard.client.createAndAppendtoOrder');
    Route::post('order/items/save/', [OrderController::class, 'saveItems'])->name('dashboard.order.items.save');
    Route::get('order/item/delete/{orderItem}', [OrderController::class, 'deleteItem'])->name('dashboard.order.item.delete'); 
    Route::post('order/payment/save', [OrderController::class, 'addPayment'])->name('order.append.payments');
    Route::get('order/payment/delete/{payment}', [OrderController::class, 'deletePayment'])->name('order.payments.delete');
    Route::get('order/confirm/{order}', [OrderController::class, 'confirm'])->name('order.confirm');
    Route::get('order/break/{order}', [OrderController::class, 'break'])->name('order.break');
    Route::get('order/searchAvailableItems/{order}', [OrderController::class, 'searchAvailableItems'])->name('order.searchAvailableItems');
    //send transfer request to other point
    Route::get('order/openTransfer/{order}/{point}', [OrderController::class, 'openTransfer'])->name('order.openTransfer');
});
