<?php

namespace Database\Factories;

use App\Models\User;
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
            'bio' => $this->faker->paragraph, // Generates a random bio
            'phone' => $this->faker->phoneNumber, // Generates a random phone number
            'linkedin' => $this->faker->url, // Generates a random URL for LinkedIn
            'github' => $this->faker->url, // Generates a random URL for GitHub
            'website' => $this->faker->url, // Generates a random URL for personal website
            'profile_picture' => $this->faker->imageUrl(400, 400, 'people'), // Generates a random image URL (can use a local path in real scenarios)
            'resume' => 'resumes/' . Str::random(10) . '.pdf', // Generates a random path for a resume
            'user_id' => User::factory(), // Associates the profile with a random user
        ];
    }
}
