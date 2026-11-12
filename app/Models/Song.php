<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Song extends Model
{
    protected $fillable = [
        'name', 'artist_id', 'album_id', 'genre', 'season', 
        'oblozhka', 'duration', 'audio_file', 'year'
    ];

    // Связь с артистом
    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    // Связь с альбомом (может быть null, если трек сингл)
    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    // Связь с наградами (полиморфная)
    public function awards(): MorphMany
    {
        return $this->morphMany(Awardable::class, 'awardable');
    }

    // Получить все награды трека
    public function getAwardsListAttribute()
    {
        return $this->awards()->with('award')->get();
    }

    // Проверить, есть ли у трека конкретная награда
    public function hasAward($slug): bool
    {
        return $this->awards()->whereHas('award', function($query) use ($slug) {
            $query->where('slug', $slug);
        })->exists();
    }
}