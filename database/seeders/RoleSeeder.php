<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['Admin', 'Employee', 'Developer', 'Manager', 'Editor'];

        foreach ($roles as $role) {
            Role::create(['role_name' => $role]);
        }
    }
}
