<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CompanyDepartment>
 */
class CompanyDepartmentFactory extends Factory
{
    protected $model = null; // No model for pivot, but required by Factory

    public function definition(): array
    {
        $company = Company::inRandomOrder()->first();
        $department = Department::inRandomOrder()->first();
        return [
            'company_id' => $company?->id,
            'department_id' => $department?->id,
        ];
    }
}
