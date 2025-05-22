<?php

namespace Database\Factories;
use App\Models\Insertion;
use App\Models\Profiler;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'recipe_number' => $this->faker->randomDigit(),
            'profile_length' => $this->faker->numberBetween(10, 20),
            'distance_between_holes' => $this->faker->numberBetween(1, 5),
            'length_before_reset' => $this->faker->randomFloat(4, 500, 1000),
            'machine_number' => Profiler::factory()
        ];
    }
}
