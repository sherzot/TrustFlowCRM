<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * Abstract base class for all TrustFlow CRM tests.
 *
 * Every test under tests/Unit and tests/Feature extends this class
 * (via `use Tests\TestCase;`). It boots the Laravel application through
 * the standard CreatesApplication trait supplied by the framework's
 * BaseTestCase — no project-specific setup is required here yet.
 *
 * Future hooks for this class:
 *   - Tenant-context helpers (actingAsTenant())
 *   - Role-based acting-as shortcuts (actingAsRole('sales'))
 *   - Filament panel bootstrapping for resource tests
 */
abstract class TestCase extends BaseTestCase
{
    //
}
