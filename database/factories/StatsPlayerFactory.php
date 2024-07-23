<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StatsPlayer>
 */
class StatsPlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'game_id' => Game::all()->random()->id,
            'player_id' => Player::all()->random()->id,
            'goals' => fake()->numberBetween(0,5),
            'assists' => fake()->numberBetween(0,5),
            'yellow_cards' => fake()->numberBetween(0,2),
            'red_card' => fake()->numberBetween(0,1)

        ];
    }
}
