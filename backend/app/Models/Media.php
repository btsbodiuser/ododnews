<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'uploads';

    protected $fillable = [
        'filename',
        'original_name',
        'path',
        'disk',
        'mime_type',
        'size',
        'folder',
        'alt',
    ];

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }

    public function getSizeHumanAttribute(): string
    {
        $bytes = $this->size;
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1) . ' MB';
        }

        return round($bytes / 1024, 1) . ' KB';
    }

    public function scopeImages($query)
    {
        return $query->where('mime_type', 'like', 'image/%');
    }

    public function scopeFolder($query, string $folder)
    {
        return $query->where('folder', $folder);
    }
}
