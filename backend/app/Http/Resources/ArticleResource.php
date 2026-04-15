<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'body' => $this->when($request->routeIs('articles.show'), $this->body),
            'featured_image' => $this->featured_image ? asset('storage/' . $this->featured_image) : null,
            'featured_video' => $this->featured_video,
            'gallery' => $this->gallery ? array_map(fn ($img) => asset('storage/' . $img), $this->gallery) : null,
            'status' => $this->status,
            'is_featured' => $this->is_featured,
            'is_breaking' => $this->is_breaking,
            'is_trending' => $this->is_trending,
            'views_count' => $this->views_count,
            'reading_time' => $this->reading_time,
            'published_at' => $this->published_at?->toISOString(),
            'published_at_human' => $this->published_at?->diffForHumans(),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'author' => new AuthorResource($this->whenLoaded('author')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
