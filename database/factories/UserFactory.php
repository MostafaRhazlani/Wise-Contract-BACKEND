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
        // choose role not be admin or manager
        $role = Role::whereNotIn('id', [1, 4])->inRandomOrder()->first();

        // choose random compnay
        $company = Company::inRandomOrder()->first();

        // choose random department belongs to company
        $department = $company?->departments()->inRandomOrder()->first();

        // choose post belongs to department
        $post = $department?->posts()->inRandomOrder()->first();

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'phone' => fake()->phoneNumber(),
            'confirmation_status' => false,
            'join_date' => fake()->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'role_id' => $role->id,
            'company_id' => $company?->id,
            'department_id' => $department?->id,
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
