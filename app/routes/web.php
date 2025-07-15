<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiaryController;

Route::get('/', [DiaryController::class, 'index'])->name('diary.index');
Route::post('/diary', [DiaryController::class, 'store'])->name('diary.store');
Route::get('/api/diary', [DiaryController::class, 'api'])->name('diary.api');
