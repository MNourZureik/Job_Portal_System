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
            'profile_image' => $this->faker->imageUrl(300, 300, 'people', true, 'Profile'),  // Generates a random profile image URL
            'resume' => $this->faker->filePath(),  // Generates a random file path for the resume (you can adjust this based on your actual file storage system)
            'skills' => implode(', ', $this->faker->words(5)),  // Random skills as a comma-separated string
            'experience' => $this->faker->sentence(10),  // Random experience description
            'education' => $this->faker->sentence(6),  // Random education description
            'bio' => $this->faker->paragraph(3),  // Random bio
        ];
    }
}
