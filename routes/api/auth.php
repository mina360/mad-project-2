<?php

use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\API\V1\Auth\LogoutController;
use Illuminate\Support\Facades\Route;

Route::post('/login', LoginController::class);
Route::post('/logout', LogoutController::class)->middleware('auth:sanctum');