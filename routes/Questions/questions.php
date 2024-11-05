<?php

use App\Http\Controllers\Api\V1\QuestionsController;
use Illuminate\Support\Facades\Route;



Route::controller(QuestionsController::class)->group(function () {
    Route::post('/addQuestion',  'store');
    Route::delete('/deleteQuestion/{question}', 'destroy');
})->middleware('auth:sanctum');
