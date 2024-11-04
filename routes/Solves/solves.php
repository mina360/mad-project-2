<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SolveController;

Route::middleware('auth:sanctum')->controller(SolveController::class)->group(function () {
    Route::post('/student/add-solve/{exam_id}', 'addSolve');
});
