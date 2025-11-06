<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiaryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// 日記API
Route::get('/diary', [DiaryController::class, 'api']);
Route::post('/diary', [DiaryController::class, 'apiStore']);