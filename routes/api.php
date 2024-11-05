<?php

use App\Http\Controllers\Api\V1\QuestionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


include __DIR__ . "/api/Exams/exams.php";
include __DIR__ . "/api/auth.php";


include __DIR__ . '/Answer/answer.php';
include __DIR__ . '/Questions/questions.php';

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
