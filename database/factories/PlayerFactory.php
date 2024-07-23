<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'birthdate' => fake()->date($format = 'Y-m-d', $max = '-15 years', $min = '-40 years'),
            'position' => fake()->randomElement(['Striker', 'Midfielder', 'Defense', 'Goalkeeper']),
            'team_id' => Team::all()->random()->id
        ];
    }
}
