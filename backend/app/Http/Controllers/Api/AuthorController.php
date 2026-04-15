<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AuthorController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $authors = Author::query()
            ->active()
            ->withCount('articles')
            ->get();

        return AuthorResource::collection($authors);
    }

    public function show(string $slug): AuthorResource
    {
        $author = Author::query()
            ->active()
            ->where('slug', $slug)
            ->withCount('articles')
            ->firstOrFail();

        return new AuthorResource($author);
    }
}
