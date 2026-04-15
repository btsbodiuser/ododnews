<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $categories = Category::query()
            ->active()
            ->parents()
            ->with(['children' => fn ($q) => $q->active()])
            ->withCount('articles')
            ->orderBy('sort_order')
            ->get();

        return CategoryResource::collection($categories);
    }

    public function menu(): AnonymousResourceCollection
    {
        $categories = Category::query()
            ->active()
            ->menu()
            ->parents()
            ->with(['children' => fn ($q) => $q->active()->menu()])
            ->orderBy('sort_order')
            ->get();

        return CategoryResource::collection($categories);
    }

    public function show(string $slug): CategoryResource
    {
        $category = Category::query()
            ->active()
            ->where('slug', $slug)
            ->withCount('articles')
            ->with(['children' => fn ($q) => $q->active()])
            ->firstOrFail();

        return new CategoryResource($category);
    }
}
