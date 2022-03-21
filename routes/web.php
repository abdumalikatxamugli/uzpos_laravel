<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::view("/", "login");
Route::post("/", [AuthController::class, 'login_from_interface'])->name("login_interface");
