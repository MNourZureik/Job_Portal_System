<?php

namespace Database\Seeders;

use App\Models\users\JobSeeker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobSeekerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JobSeeker::factory(5)->create();
    }
}
