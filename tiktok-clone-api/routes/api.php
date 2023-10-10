<?php

use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\GlobalController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\LikeController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/get-random-users', [GlobalController::class, 'getRandomUsers']);
Route::get('/home', [HomeController::class, 'index']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logged-in-user', [UserController::class, 'loggedInUser']);
    Route::post('/update-user-image', [UserController::class, 'updateUserImage']);
    Route::patch('/update-user', [UserController::class, 'updateUser']);

    Route::get('/posts/{id}', [PostController::class, 'show']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);

    Route::get('/profiles/{id}', [ProfileController::class, 'show']);

    Route::post('/comments', [CommentController::class, 'store']);
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);

    Route::post('/likes', [LikeController::class, 'store']);
    Route::delete('/likes/{id}', [LikeController::class, 'destroy']);

});
