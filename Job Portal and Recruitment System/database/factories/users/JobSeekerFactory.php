<?php

namespace Database\Factories\users;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class JobSeekerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),  // Associates the job seeker with a random user
            'skills' => implode(', ', $this->faker->words(5)),  // Random skills as a comma-separated string
            'experience' => $this->faker->sentence(10),  // Random experience description
            'education' => $this->faker->sentence(6),  // Random education description
            'bio' => $this->faker->paragraph(3),  // Random bio
        ];
    }
}
