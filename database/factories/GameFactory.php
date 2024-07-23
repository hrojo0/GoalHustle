<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $homeTeam = Team::all()->random()->id;
        $awayTeam = Team::all()->random()->id;

        // Ensure that home_team_id is not equal to away_team_id
        while ($homeTeam === $awayTeam || Game::where('home_team_id', $homeTeam)->where('away_team_id', $awayTeam)->exists()) {
            $homeTeam = Team::all()->random()->id;
            $awayTeam = Team::all()->random()->id;
        }

        return [
            'tournament_id' => Tournament::all()->random()->id,
            'home_team_id' => $homeTeam,
            'away_team_id' => $awayTeam,
            'matchday' => fake()->dateTimeBetween('-1 month','+2 months'),
            'home_goals' => fake()->numberBetween(1, 60),
            'home_goals' => fake()->numberBetween(0, 8),
            'away_goals' => fake()->numberBetween(0, 8),
        ];
    }
}

