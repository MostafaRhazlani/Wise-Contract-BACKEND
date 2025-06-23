<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Role;
use App\Models\Company;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $role = Role::inRandomOrder()->first();
        $company = Company::inRandomOrder()->first();

        // Don't assign department and post for admin or manager roles
        $isDepartmentRole = !in_array(strtolower($role->role_name), ['admin', 'manager']);
        
        $department = $isDepartmentRole && $company ? $company->departments()->inRandomOrder()->first() : null;

        $post = $isDepartmentRole && $department ? $department->posts()->inRandomOrder()->first() : null;

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'phone' => fake()->phoneNumber(),
            'confirmation_status' => false,
            'join_date' => fake()->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'role_id' => Role::inRandomOrder()->first()->id,
            'department_id' => $department?->id,
            'company_id' => $company?->id,
            'post_id' => $post?->id,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
