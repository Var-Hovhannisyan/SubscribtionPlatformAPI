<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Home;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/website', [WebsiteController::class, 'store']);
Route::get('/websites', [WebsiteController::class, 'show']);
Route::post('/websites/{website}/subscribe', [SubscriptionController::class, 'subscribe'])->middleware('auth:sanctum');


Route::post('/post', [PostController::class, 'store']);
Route::get('/posts', [PostController::class, 'show']);
Route::get('posts/recent', [PostController::class, 'recent']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/{id}', [UserController::class, 'show']); // Get user by ID
    Route::get('/user', [UserController::class, 'current']); // Get current authenticated user
});

