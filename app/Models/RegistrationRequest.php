<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'status',
        'rejection_reason',
        'reviewed_at',
        'reviewed_by'
    ];

    protected $hidden = [
        'password'
    ];

    // Связь с пользователем, который рассмотрел заявку
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // Проверка статуса
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    // Accessor для аватара
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar && file_exists(storage_path('app/public/' . $this->avatar))) {
            return asset('storage/' . $this->avatar);
        }
        return asset('storage/avatars/default.png');
    }
}