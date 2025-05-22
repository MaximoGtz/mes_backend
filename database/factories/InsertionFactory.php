<?php

namespace Database\Factories;
use App\Models\Insertion;
use App\Models\Profiler;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Insertion>
 */
class InsertionFactory extends Factory
{
    protected $model = Insertion::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $createdAt = Carbon::instance($this->faker->dateTimeBetween('-7 days', 'now'));
        return [
            'recipe_number' => $this->faker->randomDigit(),
            'profile_length' => $this->faker->numberBetween(10, 20),
            'distance_between_holes' => $this->faker->numberBetween(1, 5),
            'length_before_reset' => $this->faker->randomFloat(4, 500, 1000),
            'machine_number' => Profiler::factory(),
            'good_piece' => $this->faker->boolean(80),
            'cicle_time' => $this->faker->numberBetween(1, 15),
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ];
    }
}
