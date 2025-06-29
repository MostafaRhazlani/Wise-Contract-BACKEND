<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['Admin', 'Employee', 'Manager', 'Editor', 'Developer'];

        foreach ($roles as $role) {
            Role::create(['role_name' => $role]);
        }
    }
}
