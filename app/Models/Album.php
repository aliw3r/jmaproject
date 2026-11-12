<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Album extends Model
{
    protected $fillable = [
        'name', 'artist_id', 'description', 'cover', 'release_year', 'type'
    ];

    // Связь с артистом
    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
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

    // Получить все награды альбома
    public function getAwardsListAttribute()
    {
        return $this->awards()->with('award')->get();
    }
}