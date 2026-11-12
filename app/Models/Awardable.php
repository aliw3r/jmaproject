<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Awardable extends Model
{
    protected $table = 'awardables';

    protected $fillable = [
        'award_id', 'awardable_id', 'awardable_type', 'awarded_at', 'year', 'season'
    ];

    public function award(): BelongsTo
    {
        return $this->belongsTo(Award::class);
    }

    public function awardable()
    {
        return $this->morphTo();
    }
}