<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'aliw3r',
            'email' => 'Zetalokat@gmail.com',
            'password' => Hash::make('Zetalokat1234!'),
            'role' => 'admin',
            'avatar' => 'LYO2obDIF15lLFnQKGXX9HIo2pi4EMgaphqAp5bJ.jpg',
            'is_active' => 'true',
            'approved_at' => now()
        ]);
    }
}
