<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;


// Константы ролей
    const ROLE_USER  = 0;
    const ROLE_ADMIN  = 1;
    const ROLE_EDITOR = 2;
    const ROLE_AUTHOR = 3;

    // Массив для удобства (очень полезно)
    const ROLES = [
        self::ROLE_USER  => 'Пользователь',
        self::ROLE_ADMIN  => 'Администратор',
        self::ROLE_EDITOR => 'Редактор',
        self::ROLE_AUTHOR => 'Автор',
    ];
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isEditor(): bool
    {
        return $this->role === self::ROLE_EDITOR;
    }

    public function isAuthor(): bool
    {
        return $this->role === self::ROLE_AUTHOR;
    }

    public function getRoleName(): string
    {
        return self::ROLES[$this->role] ?? 'Неизвестная роль';
    }
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    /*
    public function getRoleNameAttribute()
    {
        return [
            1 => ' (Админ)',
            2 => ' (Редактор)',
            3 => ' (Автор)',
        ][$this->role] ?? '';
    }
    */
}
