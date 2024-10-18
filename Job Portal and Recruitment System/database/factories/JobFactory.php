<?php

namespace Database\Factories;

use App\Models\users\Employer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobListing>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle,  // Generates a random job title
            'description' => $this->faker->paragraph(5),  // Generates a random paragraph for the job description
            'job_type' => $this->faker->randomElement(['Full-time', 'Part-time', 'Contract']),  // Random job type
            'company' => $this->faker->company,  // Generates a random company name
            'salary' => $this->faker->numberBetween(30000, 120000),  // Random salary
            'location' => $this->faker->address,  // Generates a random address
            'city' => $this->faker->city,  // Random city
            'country' => $this->faker->country,  // Random country
            'remotely' => $this->faker->randomElement(['yes', 'no']),  // Random choice for remote work
            'currency' => $this->faker->currencyCode,  // Generates a random currency code (e.g., USD, EUR)
            'salary_type' => $this->faker->randomElement(['Monthly', 'Yearly', 'Hourly']),  // Random salary type
            'start_date' => $this->faker->date('Y-m-d'),  // Random start date in the format YYYY-MM-DD
            'end_date' => $this->faker->date('Y-m-d'),
            'required_skills' => implode(', ', $this->faker->words(5)),  // Random skills as a comma-separated string
            'employer_id' => Employer::factory(),  // Associates a job with a randomly generated employer
        ];
    }
}
