<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_name' => $this->faker->company(),
            'owner_id' => User::inRandomOrder()->first()->id,
            'company_logo' => 'https://placehold.co/400x200/006400/FFFFFF?text=' . urlencode(strtoupper($this->faker->companySuffix())),
        ];
    }
}