<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdSlot extends Model
{
    protected $fillable = ['code', 'name', 'size', 'description', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function ads(): HasMany
    {
        return $this->hasMany(Ad::class, 'slot_id');
    }
}
