<?php

namespace Database\Seeders;
use Carbon\Carbon;
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
        // Profiler::factory(3)->create()->each(function ($profiler) {
        //     Insertion::factory(100)->create(["machine_number" => $profiler->number]);
        // });
        Profiler::factory(3)->create()->each(function ($profiler) {
            // Fecha inicial: hace una semana desde hoy
            $startDate = Carbon::now()->subWeek()->startOfDay();
            $endDate = Carbon::now()->endOfDay();

            // Iterar por cada día desde hace una semana hasta hoy
            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                // Desde las 7am hasta las 6pm (última hora para mantener 12 horas exactas)
                for ($hour = 7; $hour < 19; $hour++) {
                    $insertionCount = rand(300, 400);

                    Insertion::factory($insertionCount)->create([
                        'machine_number' => $profiler->number,
                        'created_at' => Carbon::parse($date)->setHour($hour)->setMinute(0)->setSecond(0),
                        'updated_at' => Carbon::parse($date)->setHour($hour)->setMinute(0)->setSecond(0),
                    ]);
                }
            }
        });
    }
}
