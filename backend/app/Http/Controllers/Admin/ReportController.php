<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'overview');

        $perfTopArticles = Article::orderByDesc('views_count')->take(20)->get();
        $perfByCategory  = DB::table('articles')
            ->join('categories', 'articles.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('COUNT(articles.id) as article_count'), DB::raw('SUM(articles.views_count) as views'))
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('views')->take(10)->get();

        $audit = ActivityLog::with('user')->latest()->paginate(30, ['*'], 'audit_page');

        $errorLog = $this->tailLog(40);
        $health = [
            'php_version'    => PHP_VERSION,
            'laravel'        => app()->version(),
            'env'            => app()->environment(),
            'debug'          => config('app.debug') ? 'on' : 'off',
            'storage_writable' => is_writable(storage_path()),
            'cache_writable'   => is_writable(storage_path('framework/cache')),
            'users_total'    => User::count(),
            'articles_total' => Article::count(),
        ];

        return view('admin.reports.index', compact('tab', 'perfTopArticles', 'perfByCategory', 'audit', 'errorLog', 'health'));
    }

    public function exportArticles()
    {
        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['ID', 'Title', 'Category', 'Author', 'Status', 'Views', 'Published At']);
            Article::with('category', 'author')->chunk(500, function ($rows) use ($out) {
                foreach ($rows as $a) {
                    fputcsv($out, [
                        $a->id, $a->title,
                        $a->category?->name, $a->author?->name,
                        $a->status, $a->views_count, $a->published_at,
                    ]);
                }
            });
            fclose($out);
        }, 'articles_' . now()->format('Ymd_His') . '.csv', ['Content-Type' => 'text/csv']);
    }

    public function exportAudit()
    {
        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Time', 'User', 'Action', 'Subject', 'Description', 'IP']);
            ActivityLog::with('user')->chunk(500, function ($rows) use ($out) {
                foreach ($rows as $r) {
                    fputcsv($out, [
                        $r->created_at, $r->user?->email, $r->action,
                        $r->subject_type . ($r->subject_id ? ":{$r->subject_id}" : ''),
                        $r->description, $r->ip,
                    ]);
                }
            });
            fclose($out);
        }, 'audit_' . now()->format('Ymd_His') . '.csv', ['Content-Type' => 'text/csv']);
    }

    private function tailLog(int $lines = 40): array
    {
        $path = storage_path('logs/laravel.log');
        if (! File::exists($path)) return [];
        $content = File::get($path);
        $arr = preg_split("/\r?\n/", trim($content));
        return array_slice($arr, -$lines);
    }
}
