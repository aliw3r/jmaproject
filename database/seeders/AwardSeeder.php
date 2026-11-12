<?php

namespace Database\Seeders;

use App\Models\Award;
use Illuminate\Database\Seeder;

class AwardSeeder extends Seeder
{
    public function run(): void
    {
        $awards = [
            [
                'name' => 'Трек месяца',
                'slug' => 'track-of-the-month',
                'description' => 'Лучший трек по итогам месяца',
                'icon' => '🏆',
                'category' => 'track'
            ],
            [
                'name' => 'Артист месяца',
                'slug' => 'artist-of-the-month',
                'description' => 'Лучший артист по итогам месяца',
                'icon' => '⭐',
                'category' => 'artist'
            ],
            [
                'name' => 'Альбом года',
                'slug' => 'album-of-the-year',
                'description' => 'Лучший альбом года',
                'icon' => '💿',
                'category' => 'album'
            ],
            [
                'name' => 'Трек года',
                'slug' => 'track-of-the-year',
                'description' => 'Лучший трек года',
                'icon' => '🎌',
                'category' => 'track'
            ],
            [
                'name' => 'Артист года',
                'slug' => 'artist-of-the-year',
                'description' => 'Лучший артист года',
                'icon' => '⭐',
                'category' => 'artist'
            ],
        ];

        foreach ($awards as $award) {
            Award::firstOrCreate(['slug' => $award['slug']], $award);
        }
    }
}