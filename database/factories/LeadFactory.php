<?php

namespace Database\Factories;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadFactory extends Factory
{
	protected $model = Lead::class;

	public function definition(): array
	{
		return [
			'tenant_id' => 1,
			'source' => fake()->randomElement(['website', 'referral', 'social', 'email', 'other']),
			'first_name' => fake()->firstName(),
			'last_name' => fake()->lastName(),
			'email' => fake()->unique()->safeEmail(),
			'phone' => fake()->phoneNumber(),
			'company' => fake()->company(),
			'title' => fake()->jobTitle(),
			'website' => fake()->url(),
			'industry' => fake()->randomElement(['Technology', 'Finance', 'Healthcare', 'Education', 'Retail']),
			'description' => fake()->paragraph(),
			'status' => fake()->randomElement(['new', 'contacted', 'qualified', 'converted']),
			'ai_score' => fake()->randomFloat(2, 30, 95),
		];
	}
}
