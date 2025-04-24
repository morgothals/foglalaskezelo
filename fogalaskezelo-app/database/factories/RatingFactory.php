<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Hairdresser;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rating>
 */
class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hairdresser_id' => Hairdresser::factory(),
            'stars'          => $this->faker->numberBetween(1, 5),
            'review'         => $this->faker->sentence(),
        ];
    }
}
