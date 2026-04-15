<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::prefix('v1')->group(function () {
    // Articles
    Route::get('articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('articles/featured', [ArticleController::class, 'featured'])->name('articles.featured');
    Route::get('articles/trending', [ArticleController::class, 'trending'])->name('articles.trending');
    Route::get('articles/breaking', [ArticleController::class, 'breaking'])->name('articles.breaking');
    Route::get('articles/latest', [ArticleController::class, 'latest'])->name('articles.latest');
    Route::get('articles/search', [ArticleController::class, 'search'])->name('articles.search');
    Route::get('articles/category/{slug}', [ArticleController::class, 'byCategory'])->name('articles.byCategory');
    Route::get('articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');

    // Categories
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/menu', [CategoryController::class, 'menu'])->name('categories.menu');
    Route::get('categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

    // Authors
    Route::get('authors', [AuthorController::class, 'index'])->name('authors.index');
    Route::get('authors/{slug}', [AuthorController::class, 'show'])->name('authors.show');

    // Auth
    Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::get('auth/user', [AuthController::class, 'user'])->name('auth.user');
    });
});
