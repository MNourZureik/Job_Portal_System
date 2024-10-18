<?php

namespace Database\Factories\users;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EmployerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),  // Associates the employer with a randomly generated user
            'company_name' => $this->faker->company,  // Generates a random company name
            'company_address' => $this->faker->address,  // Generates a random address
            'company_phone' => $this->faker->phoneNumber,  // Generates a random phone number
            'company_email' => $this->faker->companyEmail,  // Generates a random company email
            'company_website' => $this->faker->url,  // Generates a random company website URL
        ];
    }
}
