<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Insertion;
use App\Models\Profiler;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        Profiler::factory(3)->create()->each(function ($profiler) {
            Insertion::factory(100)->create(["machine_number" => $profiler->number]);
        });
    }
}
