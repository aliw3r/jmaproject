<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Award extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'icon', 'category'
    ];

    // Связь с сущностями через полиморфную таблицу
    public function awardables(): MorphMany
    {
        return $this->morphMany(Awardable::class, 'awardable');
    }

    // Получить все треки с этой наградой
    public function songs()
    {
        return $this->morphedByMany(Song::class, 'awardable');
    }

    // Получить всех артистов с этой наградой
    public function artists()
    {
        return $this->morphedByMany(Artist::class, 'awardable');
    }

    // Получить все альбомы с этой наградой
    public function albums()
    {
        return $this->morphedByMany(Album::class, 'awardable');
    }
}