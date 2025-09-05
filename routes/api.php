<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\EncryptionController;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

// Protected routes (require Sanctum authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'userInfo']);
    Route::post('/logout', [UserController::class, 'logout']);

    // Example: all task routes protected
    Route::get('/articles', [ArticleController::class, 'index']);        // List all
    Route::get('/article/{id}', [ArticleController::class, 'show']);    // Single article
    Route::post('/articles', [ArticleController::class, 'store']);      // Create
    Route::put('/article/{id}', [ArticleController::class, 'update']);      // Update
    Route::delete('/article/{id}', [ArticleController::class, 'destroy']); // Delete

    Route::post('/encrypt', [EncryptionController::class, 'encrypt']);
    Route::post('/decrypt', [EncryptionController::class, 'decrypt']);
});
