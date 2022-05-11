<?php
//Bismillahir Rohmanir Rohiym

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CRUD\ClientController;
use App\Http\Controllers\CRUD\ItemController;
use App\Http\Controllers\CRUD\MetricController;
use App\Http\Controllers\CRUD\OrderItemController;
use App\Http\Controllers\CRUD\PartyController;
use App\Http\Controllers\CRUD\PaymentController;
use App\Http\Controllers\CRUD\PointController;
use App\Http\Controllers\CRUD\PointProductController;
use App\Http\Controllers\CRUD\ProductController;
use App\Http\Controllers\CRUD\TransferController;
use App\Http\Controllers\CRUD\TransferItemController;
use App\Http\Controllers\CRUD\UserController;
use App\Http\Controllers\TelegramController;

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
    Route::apiResource("/staff", UserController::class);
    Route::apiResource("/points", PointController::class);
    Route::apiResource("/metrics", MetricController::class);
    Route::apiResource("/products", ProductController::class);
    Route::apiResource("/party", PartyController::class);
    Route::apiResource("/items", ItemController::class);
    Route::apiResource("/transfers", TransferController::class);
    Route::apiResource("/transfer_items", TransferItemController::class);
    Route::apiResource("/clients", ClientController::class);
    // Route::apiResource("/orders", OrderResourceController::class);
    Route::apiResource("/order_items", OrderItemController::class);
    Route::apiResource("/point_products", PointProductController::class);
    Route::apiResource("/payments", PaymentController::class);
 
    
});

// Telegram bot

Route::post("/tg/{botname}", TelegramController::class);
