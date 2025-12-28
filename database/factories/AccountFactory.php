<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
	protected $model = Account::class;

	public function definition(): array
	{
		return [
			'tenant_id' => 1,
			'name' => fake()->company(),
			'industry' => fake()->randomElement(['Technology', 'Finance', 'Healthcare', 'Education', 'Retail', 'Manufacturing']),
			'website' => fake()->url(),
			'phone' => fake()->phoneNumber(),
			'email' => fake()->companyEmail(),
			'address' => fake()->address(),
			'city' => fake()->city(),
			'state' => fake()->state(),
			'country' => fake()->country(),
			'postal_code' => fake()->postcode(),
			'annual_revenue' => fake()->randomFloat(2, 100000, 10000000),
			'employee_count' => fake()->numberBetween(10, 1000),
			'status' => fake()->randomElement(['active', 'inactive']),
			'ai_score' => fake()->randomFloat(2, 40, 95),
		];
	}
}
