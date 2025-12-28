<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Deal;
use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
	protected $model = Project::class;

	public function definition(): array
	{
		$budget = fake()->randomFloat(2, 10000, 200000);
		$actualCost = fake()->randomFloat(2, 5000, $budget);

		return [
			'tenant_id' => 1,
			'deal_id' => Deal::factory(),
			'account_id' => Account::factory(),
			'name' => fake()->sentence(3),
			'description' => fake()->paragraph(),
			'status' => fake()->randomElement(['planning', 'active', 'on_hold', 'completed', 'cancelled']),
			'start_date' => fake()->dateTimeBetween('-1 month', 'now'),
			'end_date' => fake()->dateTimeBetween('now', '+6 months'),
			'budget' => $budget,
			'currency' => fake()->randomElement(['USD', 'EUR', 'GBP']),
			'actual_cost' => $actualCost,
			'profit' => $budget - $actualCost,
			'progress' => fake()->numberBetween(0, 100),
		];
	}
}
