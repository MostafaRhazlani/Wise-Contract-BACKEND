<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            DepartmentSeeder::class,
            CompanySeeder::class,
            PostSeeder::class,
            CompanyDepartmentSeeder::class,
            UserSeeder::class,
            VariableSeeder::class,
        ]);
    }
}
