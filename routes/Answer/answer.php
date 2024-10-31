<?php

use App\Http\Controllers\Api\V1\AnswerController;
use Illuminate\Support\Facades\Route;


Route::controller(AnswerController::class)->group(function () {
    Route::post('addAnswer', 'store');
    Route::delete('deleteAnswer/{answer}', 'destroy');
})->middleware('auth:sanctum');
