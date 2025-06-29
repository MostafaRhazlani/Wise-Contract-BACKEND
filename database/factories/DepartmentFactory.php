<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Department::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $departmentNames = [
            'Engineering', 'Marketing', 'Sales', 'Support', 'Design',
            'Operations', 'Finance', 'Legal', 'Security', 'Analytics'
        ];

        return [
            'department_name' => $this->faker->randomElement($departmentNames) . ' ' . $this->faker->word(),
        ];
    }
}
