<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $managers = User::factory()->count(5)->create([
            'role_id' => Role::where('role_name', 'Manager')->first()->id,
        ]);

        // Create additional random companies
        $managers->each(function ($manager) {
            Company::factory()->create([
            'owner_id' => $manager->id,
        ]);
});
    }
}