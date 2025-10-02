<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PastoralFactory extends Factory
{
    public function definition(): array
    {
        $name = ucwords(fake()->words(3, true));

        return [
            'community_id' => rand(1, 6),
            'user_id' => \App\Models\User::factory(),
            'name' => $name,
            'slug' => str()->slug($name, '_'),
            'description' => fake()->paragraph(),
        ];
    }
}
