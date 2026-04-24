<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasApiTokens, Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_EDITOR = 'editor';
    public const ROLE_AUTHOR = 'author';

    protected $fillable = [
        'name', 'email', 'password', 'is_admin',
        'role', 'avatar', 'two_factor_secret', 'two_factor_enabled',
        'status', 'last_login_at', 'invite_token',
    ];

    protected $hidden = ['password', 'remember_token', 'two_factor_secret'];

    protected function casts(): array
    {
        return [
            'email_verified_at'   => 'datetime',
            'password'            => 'hashed',
            'is_admin'            => 'boolean',
            'two_factor_enabled'  => 'boolean',
            'last_login_at'       => 'datetime',
        ];
    }

    public function hasRole(string|array $role): bool
    {
        $roles = (array) $role;
        return in_array($this->role, $roles, true);
    }

    public function isAdmin(): bool { return $this->role === self::ROLE_ADMIN || $this->is_admin; }
    public function isEditor(): bool { return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_EDITOR], true) || $this->is_admin; }
    public function isAuthor(): bool { return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_EDITOR, self::ROLE_AUTHOR], true); }

    public function isActive(): bool
    {
        return ($this->status ?? 'active') === 'active';
    }

    public function canAccessAdmin(): bool
    {
        return $this->isAuthor() && $this->isActive();
    }
}
