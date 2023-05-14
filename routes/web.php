<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Dashboard\BrandResourceController;
use App\Http\Controllers\Dashboard\CategoryResourceController;
use App\Http\Controllers\Dashboard\ClientResourceController;
use App\Http\Controllers\Dashboard\ExpenseResourceController;
use App\Http\Controllers\Dashboard\ItemResourceController;
use App\Http\Controllers\Dashboard\MetricResourceControlller;
use App\Http\Controllers\Dashboard\PartyResourceController;
use App\Http\Controllers\Dashboard\PointResourceController;
use App\Http\Controllers\Dashboard\ProductResourceController;
use App\Http\Controllers\Dashboard\ReportContoller;
use App\Http\Controllers\Dashboard\TransferItemResourceController;
use App\Http\Controllers\Dashboard\TransferResourceController;
use App\Http\Controllers\Dashboard\UserResourceController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DebtController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\TransferRequestController;
use Illuminate\Support\Facades\Route;

Route::view("/", "login")->name("dashboard.login");
Route::post("/", [AuthController::class, 'login'])->name("dashboard.login");

Route::group(['middleware'=>['auth'], 'prefix'=>'dashboard'], function(){
    Route::get("main", [DashboardController::class, 'main'])->name('dashboard.main');
    //basic crud routes
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
    Route::resource('transferItem', TransferItemResourceController::class, ['as'=>'dashboard']);
    Route::resource('expense', ExpenseResourceController::class, ['as'=>'dashboard']);
    //transfer status change
    Route::get('transfer/finish/{transfer}', [TransferResourceController::class, 'finish'])->name('dashboard.transfer.finish');
    //party status change
    Route::get('party/finish/{party}', [PartyResourceController::class, 'finish'])->name('dashboard.party.finish');
    Route::get('logout', [AuthController::class, 'logout'])->name('dashboard.logout');
    //order routes
   
    Route::get('neworder/{type}', [OrderController::class, 'new'])->name('dashboard.order.new');
    Route::get('orders/edit/{order}', [OrderController::class, 'edit'])->name('dashboard.orders.edit');  
    Route::get('orders/{status}/{other_shop?}', [OrderController::class, 'index'])->name('dashboard.orders.index');  
    
    Route::post('order/items/save/', [OrderController::class, 'saveItems'])->name('dashboard.order.items.save');
    Route::get('order/item/delete/{orderItem}', [OrderController::class, 'deleteItem'])->name('dashboard.order.item.delete'); 
    
    Route::post('order/payment/save', [OrderController::class, 'addPayment'])->name('order.append.payments');
    Route::get('order/payment/delete/{payment}', [OrderController::class, 'deletePayment'])->name('order.payments.delete');
    
    Route::get('order/confirm/{order}', [OrderController::class, 'confirm'])->name('order.confirm');
    Route::get('order/break/{order}', [OrderController::class, 'break'])->name('order.break');
    Route::get('order/searchAvailableItems/{order}', [OrderController::class, 'searchAvailableItems'])->name('order.searchAvailableItems');
    Route::post('order/changeFromPoint/{order}', [OrderController::class, 'changeFromPoint'])->name('order.changeFromPoint');
    Route::get('client/append/{order}/{client}', [ClientController::class, 'appendToOrder'])->name('dashboard.client.append.order');
    Route::post('transferRequest/create', [TransferRequestController::class, 'createRequest'])->name('transfer.request.create');
    Route::get('transferRequests/get', [TransferRequestController::class, 'list'])->name('transfer.request.get');

    //schet faktura generate
    Route::get('order/esf/{order}', [OrderController::class, 'generateEsf'])->name('order.genEsf');
    
    //debt logic
    Route::get('debts/{client}', [DebtController::class, 'index'])->name('debt.client.index');
    Route::post('debts/repay/{payment}', [DebtController::class, 'repay'] )->name('debt.repay');
    Route::get('debts/repays/{payment}', [DebtController::class, 'repay_history'])->name('debt.repay_history');
    /**
     * 
     * Collector and delivery
     */
     Route::post('order/assignCollector/', [OrderController::class, 'assignCollector'])->name('assignCollector');
     Route::post('order/assignDeliver/', [OrderController::class, 'assignDeliver'])->name('assignDeliver');
     /**
      * Report Controller
      */
    Route::view("reports", 'dashboard.reports.main')->name('dashboard.reports.main'); 
   
    //exports

    Route::get('reports/goods-by-division/export', [ReportContoller::class, 'goodsExport'])->name('goodsExport');

    /**
     * New reports
     */
    Route::get('reports/2/1', [ReportContoller::class, 'report_2_1'])->name('dashboard.report_2_1');
    Route::get('reports/2/1/download', [ReportContoller::class, 'report_2_1_download'])->name('dashboard.report_2_1_download');

    Route::get('reports/2/2', [ReportContoller::class, 'report_2_2'])->name('dashboard.report_2_2');
    Route::get('reports/2/2/download', [ReportContoller::class, 'report_2_2_download'])->name('dashboard.report_2_2_download');
    Route::get('reports/2/3', [ReportContoller::class, 'report_2_3'])->name('dashboard.report_2_3');
    Route::get('reports/2/3/download', [ReportContoller::class, 'report_2_3_download'])->name('dashboard.report_2_3_download');
    Route::get('reports/2/4', [ReportContoller::class, 'report_2_4'])->name('dashboard.report_2_4');
    Route::get('reports/2/4/download', [ReportContoller::class, 'report_2_4_download'])->name('dashboard.report_2_4_download');
    Route::get('reports/2/5', [ReportContoller::class, 'report_2_5'])->name('dashboard.report_2_5');
    Route::get('reports/2/5/download', [ReportContoller::class, 'report_2_5_download'])->name('dashboard.report_2_5_download');


    Route::get('reports/1/1', [ReportContoller::class, 'report_1_1'])->name('dashboard.report_1_1');
    Route::get('reports/1/1/download', [ReportContoller::class, 'report_1_1_download'])->name('dashboard.report_1_1_download');
    Route::get('reports/1/2', [ReportContoller::class, 'report_1_2'])->name('dashboard.report_1_2');
    Route::get('reports/1/2/download', [ReportContoller::class, 'report_1_2_download'])->name('dashboard.report_1_2_download');
    Route::get('reports/1/3', [ReportContoller::class, 'report_1_3'])->name('dashboard.report_1_3');
    Route::get('reports/1/3/download', [ReportContoller::class, 'report_1_3_download'])->name('dashboard.report_1_3_download');
    Route::get('reports/1/4', [ReportContoller::class, 'report_1_4'])->name('dashboard.report_1_4');
    Route::get('reports/1/4/download', [ReportContoller::class, 'report_1_4_download'])->name('dashboard.report_1_4_download');


    Route::get('reports/3/1', [ReportContoller::class, 'report_3_1'])->name('dashboard.report_3_1');
    Route::get('reports/3/1/download', [ReportContoller::class, 'report_3_1_download'])->name('dashboard.report_3_1_download');
    Route::get('reports/3/2', [ReportContoller::class, 'report_3_2'])->name('dashboard.report_3_2');
    Route::get('reports/3/2/download', [ReportContoller::class, 'report_3_2_download'])->name('dashboard.report_3_2_download');
});
