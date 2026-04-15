<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'articles' => Article::count(),
            'categories' => Category::count(),
            'authors' => Author::count(),
            'tags' => Tag::count(),
            'users' => User::count(),
            'published' => Article::where('status', 'published')->count(),
            'draft' => Article::where('status', 'draft')->count(),
            'views' => Article::sum('views_count'),
        ];

        $latestArticles = Article::with('category', 'author')
            ->latest()
            ->take(5)
            ->get();

        $popularArticles = Article::with('category')
            ->orderByDesc('views_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'latestArticles', 'popularArticles'));
    }
}
