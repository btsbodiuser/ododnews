<?php

use App\Http\Controllers\Admin;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

// Public SEO endpoints
Route::get('sitemap.xml', [Admin\SeoController::class, 'sitemap']);
Route::get('robots.txt', [Admin\SeoController::class, 'robots']);

// Auth
Route::name('admin.')->group(function () {
    Route::get('login', [Admin\LoginController::class, 'showLogin'])->name('login');
    Route::post('login', [Admin\LoginController::class, 'login']);
    Route::post('logout', [Admin\LoginController::class, 'logout'])->name('logout');
});

// Admin panel (protected)
Route::name('admin.')->middleware(['web', 'auth', AdminMiddleware::class])->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Content (all roles)
    Route::resource('articles', Admin\ArticleController::class)->except('show');
    Route::resource('categories', Admin\CategoryController::class)->except('show');
    Route::resource('authors', Admin\AuthorController::class)->except('show');
    Route::resource('tags', Admin\TagController::class)->except('show');

    Route::get('media/browse', [Admin\MediaController::class, 'browse'])->name('media.browse');
    Route::post('media/bulk-destroy', [Admin\MediaController::class, 'bulkDestroy'])->name('media.bulk-destroy');
    Route::resource('media', Admin\MediaController::class)->except(['show', 'create', 'edit']);

    Route::post('upload/editor-image', [Admin\UploadController::class, 'editorImage'])->name('upload.editor-image');
    Route::post('upload/gallery', [Admin\UploadController::class, 'galleryImages'])->name('upload.gallery');

    // Notifications
    Route::get('notifications', [Admin\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/read-all', [Admin\NotificationController::class, 'readAll'])->name('notifications.read-all');
    Route::get('notifications/{notification}/read', [Admin\NotificationController::class, 'read'])->name('notifications.read');

    // Engagement (editor+)
    Route::middleware('role:admin,editor')->group(function () {
        Route::get('comments', [Admin\CommentController::class, 'index'])->name('comments.index');
        Route::patch('comments/{comment}', [Admin\CommentController::class, 'update'])->name('comments.update');
        Route::delete('comments/{comment}', [Admin\CommentController::class, 'destroy'])->name('comments.destroy');
        Route::post('comments/bulk', [Admin\CommentController::class, 'bulk'])->name('comments.bulk');
        Route::post('comments/{comment}/ban-ip', [Admin\CommentController::class, 'banIp'])->name('comments.ban-ip');

        Route::get('breaking', [Admin\BreakingAlertController::class, 'index'])->name('breaking.index');
        Route::get('breaking/create', [Admin\BreakingAlertController::class, 'create'])->name('breaking.create');
        Route::post('breaking', [Admin\BreakingAlertController::class, 'store'])->name('breaking.store');
        Route::get('breaking/{breaking}/edit', [Admin\BreakingAlertController::class, 'edit'])->name('breaking.edit');
        Route::patch('breaking/{breaking}', [Admin\BreakingAlertController::class, 'update'])->name('breaking.update');
        Route::post('breaking/{breaking}/push', [Admin\BreakingAlertController::class, 'push'])->name('breaking.push');
        Route::delete('breaking/{breaking}', [Admin\BreakingAlertController::class, 'destroy'])->name('breaking.destroy');

        // Marketing
        Route::get('subscribers/export', [Admin\SubscriberController::class, 'export'])->name('subscribers.export');
        Route::get('subscribers', [Admin\SubscriberController::class, 'index'])->name('subscribers.index');
        Route::post('subscribers', [Admin\SubscriberController::class, 'store'])->name('subscribers.store');
        Route::delete('subscribers/{subscriber}', [Admin\SubscriberController::class, 'destroy'])->name('subscribers.destroy');

        Route::get('campaigns', [Admin\CampaignController::class, 'index'])->name('campaigns.index');
        Route::get('campaigns/create', [Admin\CampaignController::class, 'create'])->name('campaigns.create');
        Route::post('campaigns', [Admin\CampaignController::class, 'store'])->name('campaigns.store');
        Route::get('campaigns/{campaign}/edit', [Admin\CampaignController::class, 'edit'])->name('campaigns.edit');
        Route::patch('campaigns/{campaign}', [Admin\CampaignController::class, 'update'])->name('campaigns.update');
        Route::post('campaigns/{campaign}/send', [Admin\CampaignController::class, 'send'])->name('campaigns.send');
        Route::delete('campaigns/{campaign}', [Admin\CampaignController::class, 'destroy'])->name('campaigns.destroy');

        Route::get('ads', [Admin\AdController::class, 'index'])->name('ads.index');
        Route::get('ads/create', [Admin\AdController::class, 'create'])->name('ads.create');
        Route::post('ads', [Admin\AdController::class, 'store'])->name('ads.store');
        Route::get('ads/{ad}/edit', [Admin\AdController::class, 'edit'])->name('ads.edit');
        Route::patch('ads/{ad}', [Admin\AdController::class, 'update'])->name('ads.update');
        Route::delete('ads/{ad}', [Admin\AdController::class, 'destroy'])->name('ads.destroy');
        Route::post('ads/slots', [Admin\AdController::class, 'storeSlot'])->name('ads.slots.store');
        Route::delete('ads/slots/{slot}', [Admin\AdController::class, 'destroySlot'])->name('ads.slots.destroy');

        Route::get('seo', [Admin\SeoController::class, 'index'])->name('seo.index');
        Route::patch('seo', [Admin\SeoController::class, 'update'])->name('seo.update');
    });

    // System (admin only)
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', Admin\UserController::class)->except('show');
        Route::patch('users/{user}/suspend', [Admin\UserController::class, 'suspend'])->name('users.suspend');

        Route::get('settings', [Admin\SettingController::class, 'index'])->name('settings.index');
        Route::patch('settings', [Admin\SettingController::class, 'update'])->name('settings.update');

        Route::get('reports', [Admin\ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/export/articles', [Admin\ReportController::class, 'exportArticles'])->name('reports.export.articles');
        Route::get('reports/export/audit', [Admin\ReportController::class, 'exportAudit'])->name('reports.export.audit');
    });
});
