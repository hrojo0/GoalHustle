<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tournament>
 */
class TournamentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tournamentNames = [
            'Copa Moribundos',
            'Stars League',
            'Copa HR'
        ];

        $name = fake()->unique()->randomElement($tournamentNames);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'season' => fake()->numberBetween(2022,2026),
            'rounds' => fake()->numberBetween(8,35),
            'logo' => 'tournaments/'.fake()->image('public/storage/tournaments', 600, 600, null, false),
        ];
    }
}
