<?php

namespace App\Models;

use App\Support\Media;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[Fillable(['username', 'full_name', 'role', 'password', 'avatar'])]
#[Hidden(['password'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;

    public const ROLE_ADMIN = 'admin';

    public const ROLE_STAFF = 'staff';

    /** Role value => label shown in forms. */
    public const ROLES = [
        self::ROLE_ADMIN => 'Admin',
        self::ROLE_STAFF => 'Staff',
    ];

    /** Only created_at exists on this table. */
    const UPDATED_AT = null;

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'created_at' => 'datetime',
        ];
    }

    /** The table has no remember_token column. */
    public function getRememberTokenName(): string
    {
        return '';
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class, 'sold_by');
    }

    /** Public URL of the avatar, or the shared fallback. */
    protected function avatarUrl(): Attribute
    {
        return Attribute::get(fn () => Media::url($this->avatar, Media::AVATAR_FALLBACK));
    }
}
