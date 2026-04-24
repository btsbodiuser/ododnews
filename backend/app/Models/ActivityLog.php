<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id', 'action', 'subject_type', 'subject_id',
        'description', 'ip', 'user_agent', 'properties',
    ];

    protected $casts = ['properties' => 'array'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function record(string $action, ?Model $subject = null, ?string $description = null, array $props = []): void
    {
        static::create([
            'user_id'      => Auth::id(),
            'action'       => $action,
            'subject_type' => $subject ? $subject::class : null,
            'subject_id'   => $subject?->getKey(),
            'description'  => $description,
            'ip'           => Request::ip(),
            'user_agent'   => substr((string) Request::userAgent(), 0, 255),
            'properties'   => $props ?: null,
        ]);
    }
}
