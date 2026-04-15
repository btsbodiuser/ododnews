<?php

use App\Http\Controllers\Admin;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

// Auth
Route::name('admin.')->group(function () {
    Route::get('login', [Admin\LoginController::class, 'showLogin'])->name('login');
    Route::post('login', [Admin\LoginController::class, 'login']);
    Route::post('logout', [Admin\LoginController::class, 'logout'])->name('logout');
});

// Admin panel (protected)
Route::name('admin.')->middleware(['web', 'auth', AdminMiddleware::class])->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('articles', Admin\ArticleController::class)->except('show');
    Route::resource('categories', Admin\CategoryController::class)->except('show');
    Route::resource('authors', Admin\AuthorController::class)->except('show');
    Route::resource('tags', Admin\TagController::class)->except('show');

    // Media library
    Route::get('media/browse', [Admin\MediaController::class, 'browse'])->name('media.browse');
    Route::post('media/bulk-destroy', [Admin\MediaController::class, 'bulkDestroy'])->name('media.bulk-destroy');
    Route::resource('media', Admin\MediaController::class)->except(['show', 'create', 'edit']);

    // Uploads
    Route::post('upload/editor-image', [Admin\UploadController::class, 'editorImage'])->name('upload.editor-image');
    Route::post('upload/gallery', [Admin\UploadController::class, 'galleryImages'])->name('upload.gallery');
});
