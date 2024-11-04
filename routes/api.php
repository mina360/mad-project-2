<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

include __DIR__ . "/Exams/exams.php";
include __DIR__ . "/Solves/solves.php";
include __DIR__ . "/api/auth.php";


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
