<?php

namespace Database\Factories;

use App\Models\Deal;
use App\Models\Account;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class DealFactory extends Factory
{
	protected $model = Deal::class;

	public function definition(): array
	{
		$stages = ['new', 'qualified', 'discovery', 'proposal', 'negotiation', 'won', 'lost'];
		$statuses = ['open', 'won', 'lost'];

		return [
			'tenant_id' => 1,
			'account_id' => Account::factory(),
			'contact_id' => Contact::factory(),
			'name' => fake()->sentence(3),
			'description' => fake()->paragraph(),
			'value' => fake()->randomFloat(2, 5000, 500000),
			'currency' => fake()->randomElement(['USD', 'EUR', 'GBP']),
			'stage' => fake()->randomElement($stages),
			'probability' => fake()->numberBetween(0, 100),
			'expected_close_date' => fake()->dateTimeBetween('now', '+6 months'),
			'status' => fake()->randomElement($statuses),
			'ai_score' => fake()->randomFloat(2, 40, 90),
		];
	}
}
