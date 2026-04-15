<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleDetailResource;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ArticleController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $articles = Article::query()
            ->published()
            ->with(['category', 'author', 'tags'])
            ->when($request->category, fn ($q, $cat) => $q->whereHas('category', fn ($q) => $q->where('slug', $cat)))
            ->when($request->tag, fn ($q, $tag) => $q->whereHas('tags', fn ($q) => $q->where('slug', $tag)))
            ->when($request->author, fn ($q, $author) => $q->whereHas('author', fn ($q) => $q->where('slug', $author)))
            ->latest('published_at')
            ->paginate($request->integer('per_page', 12));

        return ArticleResource::collection($articles);
    }

    public function show(string $slug): ArticleDetailResource
    {
        $article = Article::query()
            ->published()
            ->with(['category', 'author', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();

        $article->incrementViews();

        $article->setRelation('related', Article::query()
            ->published()
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->with(['category', 'author'])
            ->latest('published_at')
            ->limit(4)
            ->get()
        );

        return new ArticleDetailResource($article);
    }

    public function featured(): AnonymousResourceCollection
    {
        $articles = Article::query()
            ->published()
            ->featured()
            ->with(['category', 'author'])
            ->latest('published_at')
            ->limit(5)
            ->get();

        return ArticleResource::collection($articles);
    }

    public function trending(): AnonymousResourceCollection
    {
        $articles = Article::query()
            ->published()
            ->trending()
            ->with(['category', 'author'])
            ->orderByDesc('views_count')
            ->limit(10)
            ->get();

        return ArticleResource::collection($articles);
    }

    public function breaking(): AnonymousResourceCollection
    {
        $articles = Article::query()
            ->published()
            ->breaking()
            ->with(['category', 'author'])
            ->latest('published_at')
            ->limit(5)
            ->get();

        return ArticleResource::collection($articles);
    }

    public function latest(): AnonymousResourceCollection
    {
        $articles = Article::query()
            ->published()
            ->with(['category', 'author'])
            ->latest('published_at')
            ->limit(12)
            ->get();

        return ArticleResource::collection($articles);
    }

    public function search(Request $request): AnonymousResourceCollection
    {
        $request->validate([
            'q' => 'required|string|min:2|max:100',
        ]);

        $articles = Article::query()
            ->published()
            ->with(['category', 'author', 'tags'])
            ->whereFullText(['title', 'excerpt', 'body'], $request->q)
            ->latest('published_at')
            ->paginate($request->integer('per_page', 12));

        return ArticleResource::collection($articles);
    }

    public function byCategory(string $slug): AnonymousResourceCollection
    {
        $articles = Article::query()
            ->published()
            ->with(['category', 'author', 'tags'])
            ->whereHas('category', fn ($q) => $q->where('slug', $slug))
            ->latest('published_at')
            ->paginate(12);

        return ArticleResource::collection($articles);
    }
}
