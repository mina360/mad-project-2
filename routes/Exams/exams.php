<?php

use App\Http\Controllers\ExamController;
use Illuminate\Support\Facades\Route;


Route::controller(ExamController::class)->group(function () {
    Route::post('add-exam', 'add');
    Route::post('delete-exam/{exam}', 'delete');
})->middleware('auth:sanctum');
