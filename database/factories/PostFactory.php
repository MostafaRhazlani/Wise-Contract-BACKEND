<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jobTitles = [
            'Software Engineer',
            'Senior Developer',
            'Team Lead',
            'Project Manager',
            'Business Analyst',
            'UI/UX Designer',
            'Quality Assurance Engineer',
            'DevOps Engineer',
            'Data Analyst',
            'Product Manager',
            'Marketing Specialist',
            'Sales Representative',
            'HR Manager',
            'Finance Analyst',
            'Operations Manager'
        ];

        return [
            'title' => $this->faker->randomElement($jobTitles),
            'department_id' => Department::inRandomOrder()->first()->id,
        ];
    }
}