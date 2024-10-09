<?php

namespace Database\Seeders;

use App\Models\users\Employer;
use Illuminate\Database\Seeder;

class EmployerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employer::factory(5)->create();
    }
}
