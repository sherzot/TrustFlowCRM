<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * TenantFactory — test doubles for App\Models\Tenant.
 *
 * The tenants table's custom columns (id, name, plan, status) are declared in
 * Tenant::getCustomColumns(). Everything else lives inside the JSON `data`
 * blob. We only seed the custom columns here so tests remain predictable.
 */
class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->company(),
            'plan' => fake()->randomElement(['basic', 'pro', 'enterprise']),
            'status' => 'active',
        ];
    }

    /**
     * An inactive (suspended) tenant.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }
}
