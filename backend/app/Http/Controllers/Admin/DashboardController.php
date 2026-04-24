<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Article;
use App\Models\Author;
use App\Models\BreakingAlert;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Subscriber;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'articles'         => Article::count(),
            'categories'       => Category::count(),
            'authors'          => Author::count(),
            'tags'             => Tag::count(),
            'users'            => User::count(),
            'published'        => Article::where('status', 'published')->count(),
            'draft'            => Article::where('status', 'draft')->count(),
            'scheduled'        => Article::whereNotNull('scheduled_at')->where('scheduled_at', '>', now())->count(),
            'views'            => (int) Article::sum('views_count'),
            'comments_pending' => Comment::pending()->count(),
            'subscribers'      => Subscriber::active()->count(),
            'breaking_active'  => BreakingAlert::active()->count(),
        ];

        $latestArticles  = Article::with('category', 'author')->latest()->take(5)->get();
        $popularArticles = Article::with('category')->orderByDesc('views_count')->take(5)->get();

        // Last-7-days view chart (per article published date)
        $chart = collect(range(6, 0))->map(function ($d) {
            $date = Carbon::today()->subDays($d);
            return [
                'label' => $date->format('m/d'),
                'value' => (int) Article::whereDate('created_at', $date)->count(),
            ];
        });

        $trendingTopics = Tag::withCount(['articles' => function ($q) {
            $q->where('articles.created_at', '>=', now()->subDays(7));
        }])->orderByDesc('articles_count')->take(8)->get();

        $recentActivity = ActivityLog::with('user')->latest()->take(8)->get();

        return view('admin.dashboard', compact(
            'stats', 'latestArticles', 'popularArticles', 'chart', 'trendingTopics', 'recentActivity'
        ));
    }
}
