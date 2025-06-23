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
        // Create predefined variables
        $variables = [
            ['key' => 'sender', 'label' => 'sender.name'],
            ['key' => 'receiver', 'label' => 'receiver.name'],
            ['key' => 'sender_email', 'label' => 'sender.email'],
            ['key' => 'receiver_email', 'label' => 'receiver.email'],
            ['key' => 'phone', 'label' => 'phone'],
            ['key' => 'department', 'label' => 'department.department_name'],
            ['key' => 'company_name', 'label' => 'company_name'],
            ['key' => 'current_date', 'label' => 'current_date'],
        ];

        foreach ($variables as $variable) {
            Variable::create($variable);
        }
    }
}