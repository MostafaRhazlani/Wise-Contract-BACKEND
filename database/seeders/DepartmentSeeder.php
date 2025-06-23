<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Company;
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
                'department_name' => $departmentName,
            ]);
        }

        // Attach departments to companies
        $companies = Company::all();
        $departmentsList = Department::all();

        foreach ($companies as $company) {
            // Attach 3-6 random departments to each company
            $randomDepartments = $departmentsList->random(rand(3, 6));
            $company->departments()->attach($randomDepartments);
        }
    }
}
