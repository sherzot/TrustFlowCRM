<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Project;
use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
	protected $model = Invoice::class;

	public function definition(): array
	{
		$subtotal = fake()->randomFloat(2, 1000, 50000);
		$taxRate = fake()->randomFloat(2, 0, 20);
		$taxAmount = $subtotal * ($taxRate / 100);
		$total = $subtotal + $taxAmount;

		return [
			'tenant_id' => 1,
			'project_id' => Project::factory(),
			'account_id' => Account::factory(),
			'invoice_number' => 'INV-' . now()->format('Ymd') . '-' . fake()->unique()->numberBetween(1000, 9999),
			'issue_date' => fake()->dateTimeBetween('-1 month', 'now'),
			'due_date' => fake()->dateTimeBetween('now', '+1 month'),
			'status' => fake()->randomElement(['draft', 'sent', 'paid', 'overdue', 'cancelled']),
			'subtotal' => $subtotal,
			'tax_rate' => $taxRate,
			'tax_amount' => $taxAmount,
			'total' => $total,
			'currency' => fake()->randomElement(['USD', 'EUR', 'GBP']),
			'paid_at' => fake()->optional()->dateTimeBetween('-1 month', 'now'),
			'paid_amount' => function (array $attributes) {
				return $attributes['status'] === 'paid' ? $attributes['total'] : 0;
			},
			'notes' => fake()->optional()->paragraph(),
		];
	}
}
