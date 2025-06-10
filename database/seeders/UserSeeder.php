<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * The current password being used by the seeder.
     */
    protected static ?string $password;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => static::$password ??= Hash::make('password123'),
            'confirmation_status' => true,
            'phone' => '1234567890',
            'role_id' => Role::where('role_name', 'Admin')->first()->id,
        ]);

        // Create 10 random users
        User::factory(10)->create();
    }
}
