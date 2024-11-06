<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SolveController;

Route::middleware('auth:sanctum')->controller(SolveController::class)->group(function () {
    Route::post('take-exam/{exam_id}', 'takeExam');
    Route::post('/student/add-solve/{exam_id}', 'addSolve');
    Route::post('/student/score/{exam_student_id}', 'calculateScore');
});
