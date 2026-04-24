<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = [
        'email', 'name', 'status', 'confirmation_token',
        'confirmed_at', 'unsubscribed_at', 'source', 'tags',
    ];

    protected $casts = [
        'tags' => 'array',
        'confirmed_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
    ];

    public function scopeActive($q)
    {
        return $q->where('status', 'active');
    }
}
