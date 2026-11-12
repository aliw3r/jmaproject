<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_blocked',
        'is_active',
        'approved_at',
        'avatar', // Только avatar
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ==================== АКСЕССОРЫ ДЛЯ АВАТАРКИ ====================
    
    // Получение аватарки (с дефолтной)
    public function getAvatarAttribute($value)
    {
        // Если есть своя аватарка и файл существует
        if ($value && $value !== 'avatars/default.png') {
            // Проверяем, существует ли файл
            $fullPath = storage_path('app/public/' . $value);
            if (file_exists($fullPath)) {
                return '/storage/' . $value;
            }
        }
        
        // Возвращаем дефолтную аватарку (инициалы или картинка)
        return null; // Вернем null, чтобы показать инициалы
    }

    // Проверка, есть ли у пользователя своя аватарка
    public function hasCustomAvatar()
    {
        return $this->avatar !== null && 
               $this->avatar !== 'avatars/default.png' &&
               $this->attributes['avatar'] !== null;
    }

    // ==================== СВЯЗИ ====================
    
    public function avatarRequests(): HasMany
    {
        return $this->hasMany(AvatarRequest::class);
    }

    // Получить последний активный запрос на смену аватарки
    public function getPendingAvatarRequest()
    {
        return $this->avatarRequests()->where('status', 'pending')->latest()->first();
    }

    // Проверка, есть ли ожидающий запрос на смену аватарки
    public function hasPendingAvatarRequest()
    {
        return $this->avatarRequests()->where('status', 'pending')->exists();
    }

    // ==================== ПРОВЕРКИ СТАТУСА ====================
    
    
    // Scope для активных пользователей
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->whereNotNull('approved_at');
    }

    // Scope для ожидающих модерации
    public function scopePending($query)
    {
        return $query->where('is_active', false)->whereNull('approved_at');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isActive()
    {
        return $this->is_active && $this->approved_at !== null && !$this->is_blocked;
    }

    public function isBlocked()
    {
        return $this->is_blocked;
    }
}