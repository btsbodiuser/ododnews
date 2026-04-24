<?php

namespace App\View\Composers;

use App\Models\AdminNotification;
use App\Models\Article;
use App\Models\BreakingAlert;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminComposer
{
    public function compose(View $view): void
    {
        $user = Auth::user();

        $pendingComments = Comment::pending()->count();
        $articlesAwaiting = Article::where('status', 'draft')->count();
        $breakingDrafts   = BreakingAlert::where('status', 'draft')->count();
        $unreadNotifs     = AdminNotification::unread()
            ->where(function ($q) use ($user) {
                $q->whereNull('user_id')->when($user, fn($q) => $q->orWhere('user_id', $user->id));
            })
            ->count();

        $view->with([
            'navBadges' => [
                'comments' => $pendingComments,
                'articles' => $articlesAwaiting,
                'breaking' => $breakingDrafts,
            ],
            'unreadNotifs'     => $unreadNotifs,
            'latestNotifs'     => AdminNotification::unread()
                ->where(function ($q) use ($user) {
                    $q->whereNull('user_id')->when($user, fn($q) => $q->orWhere('user_id', $user->id));
                })
                ->latest()->take(8)->get(),
        ]);
    }
}
