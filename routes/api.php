<?php
//Bismillahir Rohmanir Rohiym

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CRUD\MetricController;
use App\Http\Controllers\CRUD\PointController;
use Illuminate\Support\Facades\Route;
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
});

