<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create managers first
        $managers = User::factory()->count(5)->create([
            'role_id' => Role::where('role_name', 'Manager')->first()->id,
            'password' => Hash::make('password123'),
        ]);

        // Create companies for each manager
        $managers->each(function ($manager) {
            $company = Company::factory()->create([
                'owner_id' => $manager->id,
            ]);
            
            // Update manager with company_id
            $manager->update(['company_id' => $company->id]);
        });
    }
}