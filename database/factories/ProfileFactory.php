<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'profession' => fake()->jobTitle(),
            'about' => fake()->realText(255),
            'birthday' => fake()->date($format = 'Y-m-d', $max = '-18 years', $min = '-80 years'),
            'website' => 'https://example.com/' . Str::limit($this->faker->slug(), 10, ''),
            'twitter' => 'https://facebook.com/' . Str::limit($this->faker->slug(), 10, ''),
            'linkedin' => 'https://twitter.com/' . Str::limit($this->faker->slug(), 10, ''),
            'facebook' => 'https://facebook.com/' . Str::limit($this->faker->slug(), 10, ''),
        ];
    }
}
