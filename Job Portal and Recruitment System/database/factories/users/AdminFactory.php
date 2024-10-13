<?php

namespace Database\Factories\users;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),  // Associates an admin with a randomly generated user
            'access_level' => $this->faker->randomElement(['low', 'medium', 'high']),  // Random access level
            'status' => $this->faker->randomElement(['active', 'inactive', 'suspended']),  // Random status
        ];
    }
}
