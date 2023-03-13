<?php
//Bismillahir Rohmanir Rohiym

use Illuminate\Support\Facades\Route;
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
// Telegram bot

Route::post("/tg/{botname}", TelegramController::class);
