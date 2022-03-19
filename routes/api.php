<?php
//Bismillahir Rohmanir Rohiym

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CRUD\ClientController;
use App\Http\Controllers\CRUD\ItemController;
use App\Http\Controllers\CRUD\MetricController;
use App\Http\Controllers\CRUD\OrderController;
use App\Http\Controllers\CRUD\OrderItemController;
use App\Http\Controllers\CRUD\PartyController;
use App\Http\Controllers\CRUD\PaymentController;
use App\Http\Controllers\CRUD\PointController;
use App\Http\Controllers\CRUD\PointProductController;
use App\Http\Controllers\CRUD\ProductController;
use App\Http\Controllers\CRUD\TransferController;
use App\Http\Controllers\CRUD\TransferItemController;
use App\Http\Controllers\CRUD\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix("v1")->group(function(){
    Route::post("/login", [AuthController::class, 'login']);

});
Route::prefix("v1")->middleware('token_auth')->group(function(){
    Route::get('/current/user',  [AuthController::class, 'getCurrentUser']);
    Route::resource("/staff", UserController::class)->except(['create', 'edit']);
    Route::resource("/points", PointController::class)->except(['create', 'edit']);
    Route::resource("/metrics", MetricController::class)->except(['create', 'edit']);
    Route::resource("/products", ProductController::class)->except(['create', 'edit']);
    Route::resource("/party", PartyController::class)->except(['create', 'edit']);
    Route::resource("/items", ItemController::class)->except(['create', 'edit']);
    Route::resource("/transfers", TransferController::class)->except(['create', 'edit']);
    Route::resource("/transfer_items", TransferItemController::class)->except(['create', 'edit']);
    Route::resource("/clients", ClientController::class)->except(['create', 'edit']);
    Route::resource("/orders", OrderController::class)->except(['create', 'edit']);
    Route::resource("/order_items", OrderItemController::class)->except(['create', 'edit']);
    Route::resource("/point_products", PointProductController::class)->except(['create', 'edit']);
    Route::resource("/payments", PaymentController::class)->except(['create', 'edit']);
});

/*
1. Product CRUD
2. Party
3. Items
4. transfers
5. transfer_items
6. clients
7. orders
8. order items
9. point products
10. payments - LC
*/
