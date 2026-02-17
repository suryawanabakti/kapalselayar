<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'nik' => '1234567890123456',
            'phone' => '08123456789',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'super',
            'email' => 'super@example.com',
            'nik' => '1234567890123451',
            'phone' => '08123456789',
            'role' => 'super_admin',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'nik' => '1234567890123422',
            'phone' => '08123456789',
            'role' => 'user',
        ]);

        $ship1 = \App\Models\Ship::create([
            'name' => 'KM Selayar Baru',
            'capacity' => 100,
        ]);

        $ship2 = \App\Models\Ship::create([
            'name' => 'Kapal Fery Lestari',
            'capacity' => 200,
        ]);

        \App\Models\Schedule::create([
            'ship_id' => $ship1->id,
            'departure_date' => now()->addDays(2)->format('Y-m-d'),
            'departure_time' => '08:00:00',
            'price' => 150000,
            'quota' => 50,
        ]);

        \App\Models\Schedule::create([
            'ship_id' => $ship2->id,
            'departure_date' => now()->addDays(5)->format('Y-m-d'),
            'departure_time' => '14:30:00',
            'price' => 200000,
            'quota' => 30,
        ]);
    }
}
