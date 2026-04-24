<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Article;
use App\Models\BannedIp;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(string $articleSlug): JsonResponse
    {
        $article = Article::where('slug', $articleSlug)->firstOrFail();

        $comments = Comment::approved()
            ->where('article_id', $article->id)
            ->whereNull('parent_id')
            ->with(['replies' => fn ($q) => $q->approved()->latest(), 'user:id,name,avatar'])
            ->latest()
            ->take(50)
            ->get();

        return response()->json(['data' => $comments]);
    }

    public function store(Request $request, string $articleSlug): JsonResponse
    {
        $article = Article::where('slug', $articleSlug)->firstOrFail();

        if (BannedIp::where('ip', $request->ip())->exists()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $request->validate([
            'body'         => 'required|string|min:2|max:2000',
            'author_name'  => 'nullable|string|max:100',
            'author_email' => 'nullable|email|max:150',
            'parent_id'    => 'nullable|exists:comments,id',
        ]);

        $user = $request->user();
        $body = $this->profanityFilter($data['body']);

        $comment = Comment::create([
            'article_id'   => $article->id,
            'user_id'      => $user?->id,
            'parent_id'    => $data['parent_id'] ?? null,
            'author_name'  => $user?->name ?? $data['author_name'] ?? 'Зочин',
            'author_email' => $user?->email ?? $data['author_email'] ?? null,
            'author_ip'    => $request->ip(),
            'body'         => $body,
            'status'       => $user ? 'approved' : 'pending',
        ]);

        if ($comment->status === 'pending') {
            AdminNotification::notify(
                'comment.pending',
                "Шинэ сэтгэгдэл: {$article->title}",
                url('/admin/comments?status=pending'),
                'info',
                mb_substr($body, 0, 120)
            );
        }

        return response()->json([
            'data'    => $comment,
            'message' => $comment->status === 'pending' ? 'Сэтгэгдэл хянагдаж байна.' : 'Сэтгэгдэл нэмэгдлээ.',
        ], 201);
    }

    private function profanityFilter(string $text): string
    {
        $banned = ['fuck', 'shit', 'cunt']; // expand as needed
        return str_ireplace($banned, '***', $text);
    }
}
