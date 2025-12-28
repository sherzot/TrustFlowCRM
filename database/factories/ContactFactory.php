<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
	protected $model = Contact::class;

	public function definition(): array
	{
		return [
			'tenant_id' => 1,
			'account_id' => Account::factory(),
			'first_name' => fake()->firstName(),
			'last_name' => fake()->lastName(),
			'email' => fake()->unique()->safeEmail(),
			'phone' => fake()->phoneNumber(),
			'mobile' => fake()->phoneNumber(),
			'title' => fake()->jobTitle(),
			'department' => fake()->randomElement(['Sales', 'Marketing', 'IT', 'Finance', 'Operations']),
			'is_primary' => fake()->boolean(20),
			'status' => fake()->randomElement(['active', 'inactive']),
		];
	}
}
