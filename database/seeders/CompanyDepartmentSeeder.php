<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class CompanyDepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();
        $departments = Department::all();

        foreach ($companies as $company) {
            $randomDepartments = $departments->random(rand(3, 6));
            foreach ($randomDepartments as $department) {
                DB::table('company_department')->updateOrInsert([
                    'company_id' => $company->id,
                    'department_id' => $department->id,
                ]);
            }
        }
    }
}
