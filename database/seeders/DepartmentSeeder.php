<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create predefined departments
        $departments = [
            'Information Technology',
            'Human Resources',
            'Finance',
            'Marketing',
            'Operations',
            'Research and Development',
            'Customer Service',
            'Legal',
            'Sales',
            'Quality Assurance'
        ];

        foreach ($departments as $departmentName) {
            Department::create([
                'department_name' => $departmentName
            ]);
        }

        // Create additional random departments
        Department::factory()->create();
    }
}
