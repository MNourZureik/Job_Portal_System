<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating some permissions :
        Permission::create(['name' => 'post jobs']);
        Permission::create(['name' => 'apply for jobs']);

    }
}
