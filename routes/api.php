<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\ReadingListController;
use App\Http\Controllers\Api\ReadingProgressController;

Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::get('/books/{id}/chapters/{chapterId}', [BookController::class, 'chapter']);
Route::get('/me', [BookController::class, 'me']);

// Reading Lists
Route::get('/reading-lists', [ReadingListController::class, 'index']);
Route::post('/reading-lists', [ReadingListController::class, 'store']);
Route::get('/reading-lists/{id}', [ReadingListController::class, 'show']);
Route::post('/reading-lists/{id}/books', [ReadingListController::class, 'addBook']);
Route::delete('/reading-lists/{id}/books/{bookId}', [ReadingListController::class, 'removeBook']);
Route::delete('/reading-lists/{id}', [ReadingListController::class, 'destroy']);

// Reading Progress
Route::get('/reading-progress', [ReadingProgressController::class, 'index']);
Route::get('/reading-progress/{bookId}', [ReadingProgressController::class, 'show']);
Route::get('/reading-progress/{bookId}/has', [ReadingProgressController::class, 'hasProgress']);
Route::post('/reading-progress', [ReadingProgressController::class, 'store']);


