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
            ['key' => 'user_name', 'label' => 'user.name'],
            ['key' => 'user_email', 'label' => 'user.email'],
            ['key' => 'user_phone', 'label' => 'user.phone'],
            ['key' => 'user_id', 'label' => 'user.id'],
            ['key' => 'join_date', 'label' => 'user.join_date'],
            ['key' => 'created_at', 'label' => 'user.created_at'],

            // Related fields (with relationships)
            ['key' => 'role_name', 'label' => 'user.role.role_name'],
            ['key' => 'department_name', 'label' => 'user.department.department_name'],
            ['key' => 'post_title', 'label' => 'user.post.title'],
            ['key' => 'company_name', 'label' => 'user.company.company_name'],
            ['key' => 'company_email', 'label' => 'user.company.email'],
            ['key' => 'company_phone', 'label' => 'user.company.phone'],
            ['key' => 'company_address', 'label' => 'user.company.address'],

            // System fields
            ['key' => 'current_date', 'label' => 'current_date'],
            ['key' => 'current_time', 'label' => 'current_time'],
            ['key' => 'current_year', 'label' => 'current_year'],
        ];

        foreach ($variables as $variable) {
            Variable::create($variable);
        }
    }
}