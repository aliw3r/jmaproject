<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Artist extends Model
{
    protected $fillable = [
        'name', 'description', 'photo', 'country', 'debut_year'
    ];

    // Связь с альбомами
    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }

    // Связь с треками
    public function songs(): HasMany
    {
        return $this->hasMany(Song::class);
    }

    // Связь с наградами (полиморфная)
    public function awards(): MorphMany
    {
        return $this->morphMany(Awardable::class, 'awardable');
    }

    // Получить все награды артиста
    public function getAwardsListAttribute()
    {
        return $this->awards()->with('award')->get();
    }
}