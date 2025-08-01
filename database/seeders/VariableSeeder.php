<?php

namespace Database\Seeders;

use App\Models\Variable;
use Illuminate\Database\Seeder;

class VariableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create predefined variables that map to actual database fields
        $variables = [
            // User fields
            ['label' => 'name', 'key' => 'user.name'],
            ['label' => 'email', 'key' => 'user.email'],
            ['label' => 'phone', 'key' => 'user.phone'],
            ['label' => 'id', 'key' => 'user.id'],
            ['label' => 'join_date', 'key' => 'user.join_date'],
            ['label' => 'created_at', 'key' => 'user.created_at'],

            // Related fields (with relationships)
            ['label' => 'role_name', 'key' => 'user.role.role_name'],
            ['label' => 'department_name', 'key' => 'user.department.department_name'],
            ['label' => 'post_title', 'key' => 'user.post.title'],
            ['label' => 'company_name', 'key' => 'user.company.company_name'],
            ['label' => 'company_email', 'key' => 'user.company.email'],
            ['label' => 'company_phone', 'key' => 'user.company.phone'],
            ['label' => 'company_address', 'key' => 'user.company.address'],

            // System fields
            ['label' => 'current_date', 'key' => 'current_date'],
            ['label' => 'current_time', 'key' => 'current_time'],
            ['label' => 'current_year', 'key' => 'current_year'],
        ];

        foreach ($variables as $variable) {
            Variable::create($variable);
        }
    }
}