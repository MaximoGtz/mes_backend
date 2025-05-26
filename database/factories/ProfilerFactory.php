<?php

namespace Database\Factories;
use App\Models\Profiler;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profiler>
 */
class ProfilerFactory extends Factory
{
    protected $model = Profiler::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => 'disponible',
            'name' => $this->faker->word,
            'ip' => '192.323.123.23',
            'model' => "PROFILER" . $this->faker->randomDigit() . $this->faker->randomDigit(),
            'number' => $this->faker->unique()->numberBetween(1, 20),
            'year_model' => $this->faker->numberBetween(2000, 2025),
            'machine_speed' => $this->faker->numberBetween(10, 20)
        ];
    }
}
