<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\InterestController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\Auth\AuthUserController;
use App\Http\Controllers\Api\SavedPostController;
use App\Http\Controllers\Api\ShareController;
use App\Http\Controllers\Api\ViewLogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/register', [AuthUserController::class, 'register']);
Route::post('/login', [AuthUserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
  
    Route::post('/logout', [AuthUserController::class, 'logout']);

    Route::prefix('posts')->controller(PostController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/trending', 'trendingPosts');
        Route::get('/latest-news', 'recentPosts');
        
        Route::get('/{id}/show', 'show');
        Route::get('/category/{categoryId}', 'getPostsByCategory');
    });
    
    Route::get('/categories', [CategoryController::class, 'index']);
    
    Route::prefix('redactions')->controller(PostController::class)->group(function () {
        Route::get('/', 'getRedactions');
        Route::get('/{id}/posts', 'getRedactionPosts');
    });
    
    Route::prefix('interests')->controller(InterestController::class)->group(function () {
        Route::post('/', 'addUserInterests');
        Route::get('/', 'getInterests');
        // Route::get('/posts/interests', 'getPostsByInterests');
    });

    Route::prefix('saved-posts')->group(function () {
        Route::post('/', [SavedPostController::class, 'store']);  
        Route::get('/', [SavedPostController::class, 'index']);   
        Route::delete('/{id}', [SavedPostController::class, 'destroy']); 
    });

    Route::post('/likes', [LikeController::class, 'store']);
    Route::post('/comments', [CommentController::class, 'store']);
    Route::post('/delete-comments/{id}', [CommentController::class, 'destroy']);
    Route::post('/shares', [ShareController::class, 'store']);
    Route::post('/views', [ViewLogController::class, 'store']);
});





