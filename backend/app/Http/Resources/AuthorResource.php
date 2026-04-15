<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'bio' => $this->bio,
            'avatar' => $this->avatar,
            'position' => $this->position,
            'social_links' => $this->social_links,
            'articles_count' => $this->whenCounted('articles'),
        ];
    }
}
