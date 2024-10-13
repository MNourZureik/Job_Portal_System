<?php

namespace Database\Seeders;

use App\Models\users\Employer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call individual seeders here
        $this->call([
            RoleSeeder::class,
//            PermissionSeeder::class,
//            UserSeeder::class,
//            EmployerSeeder::class,
//            AdminSeeder::class,
//            JobSeekerSeeder::class,
//            JobSeeder::class,
        ]);
    }
}
