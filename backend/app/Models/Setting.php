<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'group', 'type'];

    public static function get(string $key, $default = null)
    {
        $cache = Cache::rememberForever('settings.all', fn () => static::pluck('value', 'key')->all());
        return $cache[$key] ?? $default;
    }

    public static function set(string $key, $value, string $group = 'general', string $type = 'string'): void
    {
        static::updateOrCreate(['key' => $key], [
            'value' => is_array($value) ? json_encode($value) : $value,
            'group' => $group,
            'type'  => $type,
        ]);
        Cache::forget('settings.all');
    }

    public static function byGroup(string $group): array
    {
        return static::where('group', $group)->pluck('value', 'key')->all();
    }
}
