<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\User as Users;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Url>
 */
class UrlFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->unique()->randomNumber(1),
            'user_id' => Users::factory()->make()->id,
            'url' => fake()->url(),
            'name' => fake()->name(),
        ];
    }
}
