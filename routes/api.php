<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MockController;

Route::get('/books', [MockController::class, 'books']);
Route::get('/books/{id}', [MockController::class, 'book']);
Route::get('/books/{id}/chapters/{chapterId}', [MockController::class, 'chapter']);
Route::get('/me', [MockController::class, 'me']);


